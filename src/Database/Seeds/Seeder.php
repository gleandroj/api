<?php

namespace Gleandroj\Api\Database\Seeds;

use Carbon\Carbon;
use Illuminate\Database\ConnectionResolverInterface as Resolver;

abstract class Seeder extends \Illuminate\Database\Seeder
{
    /**
     * Default Seeder Table Name
     */
    public static $table = 'seeders';

    /**
     * Default Connection Name
     */
    public static $connection;

    /**
     * @var Resolver
     */
    protected $resolver;

    /**
     * Deve retornar os ambientes que o Seeder deve ser executado
     * @return mixed
     */
    public abstract function getEnvironments();

    /**
     * @return mixed
     */
    public abstract function run();

    /**
     * @return null|void
     */
    public function __invoke()
    {
        if ($this->canExecute() && !$this->wasExecuted($this->getSeederName(), $this->getAppEnv())) {
            $this->insertOrUpdateSeed($this->getSeederName());
            return parent::__invoke();
        }
        return null;
    }

    /**
     * @return static
     */
    public function canExecute()
    {
        return collect($this->getEnvironments())->intersect([$this->getAppEnv()])->isNotEmpty();
    }

    /**
     * @param $seeder
     * @param $env
     * @return bool
     */
    public function wasExecuted($seeder, $env)
    {
        return ($this->table()->where('seeder', 'ilike', $seeder)->where('environment', 'ilike', "%${env}%")->count() > 0);
    }

    /**
     * Determine if the seeder repository exists.
     *
     * @return bool
     */
    public function repositoryExists()
    {
        $schema = $this->getConnection()->getSchemaBuilder();

        return $schema->hasTable($this->table);
    }

    /**
     * Create the seeder repository data store.
     *
     * @return void
     */
    public function createRepository()
    {
        $schema = $this->getConnection()->getSchemaBuilder();

        $schema->create($this->table, function ($table) {
            $table->increments('id');
            $table->string('seeder');
            $table->string('environment');
            $table->timestamp('ran_at');
        });
    }

    /**
     * @param $seeder
     * @return bool
     */
    public function insertOrUpdateSeed($seeder)
    {
        $now = Carbon::now();

        if ($seed = $this->table()->where('seeder', 'ilike', $seeder)->first()) {

            $seed->ran_at = $now;
            $env = json_decode($seed->environment);
            array_push($env, $this->getAppEnv());
            $seed->environment = json_encode($env);

            return $this->table()->where('id', '=', $seed->id)->update((array)$seed);

        } else {
            return $this->table()->insert([
                "seeder" => $seeder,
                "environment" => json_encode([$this->getAppEnv()]),
                "ran_at" => $now]);
        }

    }

    /**
     * @return string
     */
    public function getSeederName()
    {
        return get_called_class();
    }

    /**
     * Get a query builder for the migration table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function table()
    {
        return $this->getConnection()->table($this->table)->useWritePdo();
    }

    /**
     * Get the connection resolver instance.
     *
     * @return \Illuminate\Database\ConnectionResolverInterface
     */
    public function getConnectionResolver()
    {
        return $this->resolver;
    }

    /**
     * Resolve the database connection instance.
     *
     * @return \Illuminate\Database\Connection
     */
    public function getConnection()
    {
        return $this->connection ? 
                $this->getConnectionResolver()->connection($this->connection) 
                : $this->getConnectionResolver()->getDefaultConnection();
    }

    /**
     * @return mixed
     */
    private function getAppEnv()
    {
        return app()->environment();
    }

}