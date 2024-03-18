<?php

namespace Database\Seeders;

//GLOBAL IMPORT
use Illuminate\Database\Seeder;

//GLOBAL IMPORT
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name'=>'Administrator']);
        //Access control
        $role1->givePermissionTo(['name'=>'List of permissions']);
        $role1->givePermissionTo(['name'=>'Search permission by ID']);
        $role1->givePermissionTo(['name'=>'Create a permission']);
        $role1->givePermissionTo(['name'=>'Update a permission']);
        $role1->givePermissionTo(['name'=>'Delete a permission']);

        $role1->givePermissionTo(['name'=>'List of roles']);
        $role1->givePermissionTo(['name'=>'Search role by ID']);
        $role1->givePermissionTo(['name'=>'Create a role']);
        $role1->givePermissionTo(['name'=>'Update a role']);
        $role1->givePermissionTo(['name'=>'Delete a role']);

        $role1->givePermissionTo(['name'=>'List of roles and permissions']);
        $role1->givePermissionTo(['name'=>'List of permissions by role ID']);
        $role1->givePermissionTo(['name'=>'Assign permission to a role']);
        $role1->givePermissionTo(['name'=>'Delete permission to a role']);

        $role1->givePermissionTo(['name'=>'List of users']);
        $role1->givePermissionTo(['name'=>'Search user by ID']);
        $role1->givePermissionTo(['name'=>'Create an user']);
        $role1->givePermissionTo(['name'=>'Update an user']);
        $role1->givePermissionTo(['name'=>'Delete an user']);

        $role1->givePermissionTo(['name'=>'List of user and roles']);
        $role1->givePermissionTo(['name'=>'List of roles by user ID']);
        $role1->givePermissionTo(['name'=>'Assign role to a user']);
        $role1->givePermissionTo(['name'=>'Delete role to a user']);

        $role1->givePermissionTo(['name'=>'List of users and permissions']);
        $role1->givePermissionTo(['name'=>'List of permissions by user ID']);
        $role1->givePermissionTo(['name'=>'Assign permission to a user']);
        $role1->givePermissionTo(['name'=>'Delete permission to a user']);

        //Global options-------------------------------------------------
        $role1->givePermissionTo(['name'=>'Dashboard']);
        $role1->givePermissionTo(['name'=>'Profile']);
        $role1->givePermissionTo(['name'=>'Messages']);
        $role1->givePermissionTo(['name'=>'Notifications']);
        //    -------- Nomenclature tables -------------------------------
        //Campus
        $role1->givePermissionTo(['name'=>'List of campuses']);
        $role1->givePermissionTo(['name'=>'Search campus by ID']);
        $role1->givePermissionTo(['name'=>'Search campuses by status']);
        $role1->givePermissionTo(['name'=>'Create a campus']);
        $role1->givePermissionTo(['name'=>'Update a campus']);
        $role1->givePermissionTo(['name'=>'Delete a campus']);
        //College
        $role1->givePermissionTo(['name'=>'List of colleges']);
        $role1->givePermissionTo(['name'=>'Search college by ID']);
        $role1->givePermissionTo(['name'=>'Search colleges by status']);
        $role1->givePermissionTo(['name'=>'Create a college']);
        $role1->givePermissionTo(['name'=>'Update a college']);
        $role1->givePermissionTo(['name'=>'Delete a college']);
        //Department
        $role1->givePermissionTo(['name'=>'List of departments']);
        $role1->givePermissionTo(['name'=>'Search department by ID']);
        $role1->givePermissionTo(['name'=>'Search departments by status']);
        $role1->givePermissionTo(['name'=>'Create a department']);
        $role1->givePermissionTo(['name'=>'Update a department']);
        $role1->givePermissionTo(['name'=>'Delete a department']);
        //Building
        $role1->givePermissionTo(['name'=>'List of buildings']);
        $role1->givePermissionTo(['name'=>'Search building by ID']);
        $role1->givePermissionTo(['name'=>'Search buildings by status']);
        $role1->givePermissionTo(['name'=>'Create a building']);
        $role1->givePermissionTo(['name'=>'Update a building']);
        $role1->givePermissionTo(['name'=>'Delete a building']);
        //Facilities
        $role1->givePermissionTo(['name'=>'List of facilities']);
        $role1->givePermissionTo(['name'=>'Search facility by ID']);
        $role1->givePermissionTo(['name'=>'Search facilities by status']);
        $role1->givePermissionTo(['name'=>'Create a facility']);
        $role1->givePermissionTo(['name'=>'Update a facility']);
        $role1->givePermissionTo(['name'=>'Delete a facility']);

        //Schedule module
        //Term
        $role1->givePermissionTo(['name'=>'List of terms']);
        $role1->givePermissionTo(['name'=>'Search term by ID']);
        $role1->givePermissionTo(['name'=>'Search terms by status']);
        $role1->givePermissionTo(['name'=>'Create a term']);
        $role1->givePermissionTo(['name'=>'Update a term']);
        $role1->givePermissionTo(['name'=>'Delete a term']);
        //Program level
        $role1->givePermissionTo(['name'=>'List of program levels']);
        $role1->givePermissionTo(['name'=>'Search program level by ID']);
        $role1->givePermissionTo(['name'=>'Search program levels by status']);
        $role1->givePermissionTo(['name'=>'Create a program level']);
        $role1->givePermissionTo(['name'=>'Update a program level']);
        $role1->givePermissionTo(['name'=>'Delete a program level']);
        //Program grouping
        $role1->givePermissionTo(['name'=>'List of program groupings']);
        $role1->givePermissionTo(['name'=>'Search program grouping by ID']);
        $role1->givePermissionTo(['name'=>'Search programs grouping by status']);
        $role1->givePermissionTo(['name'=>'Create a program grouping']);
        $role1->givePermissionTo(['name'=>'Update a program grouping']);
        $role1->givePermissionTo(['name'=>'Delete a program grouping']);
        //Program
        $role1->givePermissionTo(['name'=>'List of programs']);
        $role1->givePermissionTo(['name'=>'Search program by ID']);
        $role1->givePermissionTo(['name'=>'Search programs by status']);
        $role1->givePermissionTo(['name'=>'Exist program by code']);
        $role1->givePermissionTo(['name'=>'Create a program']);
        $role1->givePermissionTo(['name'=>'Update a program']);
        $role1->givePermissionTo(['name'=>'Delete a program']);
        //Course
        $role1->givePermissionTo(['name'=>'List of courses']);
        $role1->givePermissionTo(['name'=>'Search course by ID']);
        $role1->givePermissionTo(['name'=>'Search courses by status']);
        $role1->givePermissionTo(['name'=>'Create a course']);
        $role1->givePermissionTo(['name'=>'Update a course']);
        $role1->givePermissionTo(['name'=>'Delete a course']);
        //Session
        $role1->givePermissionTo(['name'=>'List of sessions']);
        $role1->givePermissionTo(['name'=>'Search session by ID']);
        $role1->givePermissionTo(['name'=>'Search sessions by status']);
        $role1->givePermissionTo(['name'=>'Create a session']);
        $role1->givePermissionTo(['name'=>'Update a session']);
        $role1->givePermissionTo(['name'=>'Delete a session']);
        //Instructor mode
        $role1->givePermissionTo(['name'=>'List of instructor modes']);
        $role1->givePermissionTo(['name'=>'Search instructor mode by ID']);
        $role1->givePermissionTo(['name'=>'Search instructor modes by status']);
        $role1->givePermissionTo(['name'=>'Create an instructor mode']);
        $role1->givePermissionTo(['name'=>'Update an instructor mode']);
        $role1->givePermissionTo(['name'=>'Delete an instructor mode']);
        //Meeting pattern
        $role1->givePermissionTo(['name'=>'List of meeting pattern']);
        $role1->givePermissionTo(['name'=>'Search meeting pattern by day, hour, facility ID']);
        $role1->givePermissionTo(['name'=>'Create a meeting pattern']);
        $role1->givePermissionTo(['name'=>'Update a meeting pattern']);
        $role1->givePermissionTo(['name'=>'Delete a meeting pattern']);
        //Access periods
        $role1->givePermissionTo(['name'=>'List of access periods']);
        $role1->givePermissionTo(['name'=>'Search access period by ID']);
        $role1->givePermissionTo(['name'=>'Create an access period']);
        $role1->givePermissionTo(['name'=>'Update an access period']);
        $role1->givePermissionTo(['name'=>'Delete an access period']);
        //Sections
        $role1->givePermissionTo(['name'=>'List of sections']);
        $role1->givePermissionTo(['name'=>'Search section by ID']);
        $role1->givePermissionTo(['name'=>'Search sections by status']);
        $role1->givePermissionTo(['name'=>'Duplicate sections']);
        $role1->givePermissionTo(['name'=>'Create a section']);
        $role1->givePermissionTo(['name'=>'Update a section']);
        $role1->givePermissionTo(['name'=>'Delete a section']);
        $role1->givePermissionTo(['name'=>'Search instructor user']);

        $role2 = Role::create(['name'=>'Instructor']);
        $role3 = Role::create(['name'=>'Secretary']);
        $role4 = Role::create(['name'=>'Manager']);
        $role5 = Role::create(['name'=>'Support']);
    }
}
