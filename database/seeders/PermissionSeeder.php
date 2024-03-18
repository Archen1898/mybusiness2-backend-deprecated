<?php

namespace Database\Seeders;

//GLOBAL IMPORT
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Access control
        Permission::create(['name'=>'List of permissions']);
        Permission::create(['name'=>'Search permission by ID']);
        Permission::create(['name'=>'Create a permission']);
        Permission::create(['name'=>'Update a permission']);
        Permission::create(['name'=>'Delete a permission']);

        Permission::create(['name'=>'List of roles']);
        Permission::create(['name'=>'Search role by ID']);
        Permission::create(['name'=>'Create a role']);
        Permission::create(['name'=>'Update a role']);
        Permission::create(['name'=>'Delete a role']);

        Permission::create(['name'=>'List of roles and permissions']);
        Permission::create(['name'=>'List of permissions by role ID']);
        Permission::create(['name'=>'Assign permission to a role']);
        Permission::create(['name'=>'Delete permission to a role']);

        Permission::create(['name'=>'List of users']);
        Permission::create(['name'=>'Search user by ID']);
        Permission::create(['name'=>'Create an user']);
        Permission::create(['name'=>'Update an user']);
        Permission::create(['name'=>'Delete an user']);

        Permission::create(['name'=>'List of user and roles']);
        Permission::create(['name'=>'List of roles by user ID']);
        Permission::create(['name'=>'Assign role to a user']);
        Permission::create(['name'=>'Delete role to a user']);

        Permission::create(['name'=>'List of users and permissions']);
        Permission::create(['name'=>'List of permissions by user ID']);
        Permission::create(['name'=>'Assign permission to a user']);
        Permission::create(['name'=>'Delete permission to a user']);

        //Global options-------------------------------------------------
        Permission::create(['name'=>'Dashboard']);
        Permission::create(['name'=>'Profile']);
        Permission::create(['name'=>'Messages']);
        Permission::create(['name'=>'Notifications']);
        //    -------- Nomenclature tables -------------------------------
        //Campus
        Permission::create(['name'=>'List of campuses']);
        Permission::create(['name'=>'Search campus by ID']);
        Permission::create(['name'=>'Search campuses by status']);
        Permission::create(['name'=>'Create a campus']);
        Permission::create(['name'=>'Update a campus']);
        Permission::create(['name'=>'Delete a campus']);
        //College
        Permission::create(['name'=>'List of colleges']);
        Permission::create(['name'=>'Search college by ID']);
        Permission::create(['name'=>'Search colleges by status']);
        Permission::create(['name'=>'Create a college']);
        Permission::create(['name'=>'Update a college']);
        Permission::create(['name'=>'Delete a college']);
        //Department
        Permission::create(['name'=>'List of departments']);
        Permission::create(['name'=>'Search department by ID']);
        Permission::create(['name'=>'Search departments by status']);
        Permission::create(['name'=>'Create a department']);
        Permission::create(['name'=>'Update a department']);
        Permission::create(['name'=>'Delete a department']);
        //Building
        Permission::create(['name'=>'List of buildings']);
        Permission::create(['name'=>'Search building by ID']);
        Permission::create(['name'=>'Search buildings by status']);
        Permission::create(['name'=>'Create a building']);
        Permission::create(['name'=>'Update a building']);
        Permission::create(['name'=>'Delete a building']);
        //Facilities
        Permission::create(['name'=>'List of facilities']);
        Permission::create(['name'=>'Search facility by ID']);
        Permission::create(['name'=>'Search facilities by status']);
        Permission::create(['name'=>'Create a facility']);
        Permission::create(['name'=>'Update a facility']);
        Permission::create(['name'=>'Delete a facility']);

        //Schedule module
        //Term
        Permission::create(['name'=>'List of terms']);
        Permission::create(['name'=>'Search term by ID']);
        Permission::create(['name'=>'Search terms by status']);
        Permission::create(['name'=>'Create a term']);
        Permission::create(['name'=>'Update a term']);
        Permission::create(['name'=>'Delete a term']);
        //Program level
        Permission::create(['name'=>'List of program levels']);
        Permission::create(['name'=>'Search program level by ID']);
        Permission::create(['name'=>'Search program levels by status']);
        Permission::create(['name'=>'Create a program level']);
        Permission::create(['name'=>'Update a program level']);
        Permission::create(['name'=>'Delete a program level']);
        //Program grouping
        Permission::create(['name'=>'List of program groupings']);
        Permission::create(['name'=>'Search program grouping by ID']);
        Permission::create(['name'=>'Search programs grouping by status']);
        Permission::create(['name'=>'Create a program grouping']);
        Permission::create(['name'=>'Update a program grouping']);
        Permission::create(['name'=>'Delete a program grouping']);
        //Program
        Permission::create(['name'=>'List of programs']);
        Permission::create(['name'=>'Search program by ID']);
        Permission::create(['name'=>'Search programs by status']);
        Permission::create(['name'=>'Exist program by code']);
        Permission::create(['name'=>'Create a program']);
        Permission::create(['name'=>'Update a program']);
        Permission::create(['name'=>'Delete a program']);
        //Course
        Permission::create(['name'=>'List of courses']);
        Permission::create(['name'=>'Search course by ID']);
        Permission::create(['name'=>'Search courses by status']);
        Permission::create(['name'=>'Create a course']);
        Permission::create(['name'=>'Update a course']);
        Permission::create(['name'=>'Delete a course']);
        //Session
        Permission::create(['name'=>'List of sessions']);
        Permission::create(['name'=>'Search session by ID']);
        Permission::create(['name'=>'Search sessions by status']);
        Permission::create(['name'=>'Create a session']);
        Permission::create(['name'=>'Update a session']);
        Permission::create(['name'=>'Delete a session']);
        //Instructor mode
        Permission::create(['name'=>'List of instructor modes']);
        Permission::create(['name'=>'Search instructor mode by ID']);
        Permission::create(['name'=>'Search instructor modes by status']);
        Permission::create(['name'=>'Create an instructor mode']);
        Permission::create(['name'=>'Update an instructor mode']);
        Permission::create(['name'=>'Delete an instructor mode']);
        //Meeting pattern
        Permission::create(['name'=>'List of meeting pattern']);
        Permission::create(['name'=>'Search meeting pattern by day, hour, facility ID']);
        Permission::create(['name'=>'Create a meeting pattern']);
        Permission::create(['name'=>'Update a meeting pattern']);
        Permission::create(['name'=>'Delete a meeting pattern']);
        //Access periods
        Permission::create(['name'=>'List of access periods']);
        Permission::create(['name'=>'Search access period by ID']);
        Permission::create(['name'=>'Create an access period']);
        Permission::create(['name'=>'Update an access period']);
        Permission::create(['name'=>'Delete an access period']);
        //Sections
        Permission::create(['name'=>'List of sections']);
        Permission::create(['name'=>'Search section by ID']);
        Permission::create(['name'=>'Search sections by status']);
        Permission::create(['name'=>'Duplicate sections']);
        Permission::create(['name'=>'Create a section']);
        Permission::create(['name'=>'Update a section']);
        Permission::create(['name'=>'Delete a section']);
        Permission::create(['name'=>'Search instructor user']);

    }
}
