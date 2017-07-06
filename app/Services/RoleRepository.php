<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Role;
use App\Contracts\RoleInterface;

class RoleRepository implements RoleInterface
{
    /**
     * @param array $columns
     * @return object
     */
    public function gets(array $columns = ['*'])
    {
        return (object) Role::all((array) $columns);
    }

    /**
     * @param int $id
     * @return object
     */
    public function get(int $id)
    {
        return (object) Role::find((int) $id);
    }

    /**
     * @param string $name
     * @param array $columns
     * @return object
     */
    public function sortByName(string $name, array $columns = ['*'])
    {
        return (object) Role::where((string) 'name', (string) 'LIKE', (string) '%'.$name.'%')->get((array) $columns);
    }

    /**
     * @param int $limit
     * @param array $columns
     * @return object
     */
    public function paginate(int $limit = 25, array $columns = ['*'])
    {
        return (object) Role::paginate((int) $limit, (array) $columns);
    }

    /**
     * @param string $name
     * @param int $limit
     * @param array $columns
     * @return object
     */
    public function sortByNamePaginate(string $name, int $limit = 25, array $columns = ['*'])
    {
        return (object) Role::where((string) 'name', (string) 'LIKE', (string) '%'.$name.'%')->paginate((int) $limit);
    }

    /**
     * @param array $data
     * @return bool|object
     */
    public function save(array $data)
    {
        $role = new Role;
        foreach ($data as $item => $value) { $role->$item = $value; }
        $role->created_at = Carbon::now()->format('Y-m-d H:i:s');
        $role->updated_at = Carbon::now()->format('Y-m-d H:i:s');
        $role->save();
        return (!$role) ? (bool) false : (object) $this->get($role->id);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool|object
     */
    public function update(int $id, array $data)
    {
        $role = Role::find((int) $id);
        if (count($role) < 1) return (bool) false;
        foreach ($data as $item => $value){ $role->$item = $value;}
        $role->updated_at = Carbon::now()->format('Y-m-d H:i:s');
        $role->save();

        return (!$role) ? (bool) false : (object) $this->get($role->id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        $role = $this->get((int) $id);
        if (count($role) < 1) return (bool) false;
        $role->delete();
        return (!$role) ? (bool) false : (bool) true;
    }
}