<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(IndustriesTableSeeder::class);
        $this->call(IdentitiesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(AdminRolesTableSeeder::class);
        $this->call(PartnershipsTableSeeder::class);
        $this->call(AccountTypesTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(CompanyPartnershipsTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(CompanyAcccountTableSeeder::class);
        $this->call(CompanyAccountRelationTableSeeder::class);
        $this->call(PositionsTableSeeder::class);
        $this->call(CompanyUsersTableSeeder::class);
        $this->call(CompanyUsersRelation::class);
        $this->call(CompanyUserRolesTableSeeder::class);
        $this->call(BanksTableSeeder::class);
        $this->call(AccessConfigurationsTableSeeder::class);
        $this->call(SuperAdminRoleConfigurationsTableSeeder::class);
    }
}
