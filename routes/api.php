<?php

//LOCAL IMPORT
use App\Http\Controllers\AccessPeriodController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MeetingPatternController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\InstructorModeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProgramGroupingController;
use App\Http\Controllers\ProgramLevelController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleHasPermissionController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserHasPermissionController;
use App\Http\Controllers\UserHasRoleController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\CheckPermission;

//LOCAL IMPORT
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::controller(AuthController::class)->group(function(){
    Route::post('login','login')->name('login');
    Route::get('verify','verifyToken');
    Route::post('register','register')->name('register');
});

Route::middleware('auth:api')->group(function () {
//    Route::get('profile',[AuthController::class,'profile']);
//    Route::post('logout',[AuthController::class,'logout']);

    //access control
    Route::controller(PermissionController::class)->group(function(){
        Route::get('permission/index','indexPermissions')->middleware('permission:List of permissions');
        Route::get('permission/{id}', 'showPermission')->middleware('permission:Search permission by ID');
        Route::post('permission/add', 'addPermission')->middleware('permission:Create a permission');
        Route::put('permission/update/{id}', 'updatePermission')->middleware('permission:Update a permission');
        Route::delete('permission/delete/{id}', 'deletePermission')->middleware('permission:Delete a permission');
    });

    Route::controller(RoleController::class)->group(function(){
        Route::get('role/index','indexRoles')->middleware('permission:List of roles');
        Route::get('role/total', 'getTotalUserRoleAvatars')->middleware('permission:List of roles');
        Route::get('role/{id}', 'showRole')->middleware('permission:Search role by ID');
        Route::post('role/add', 'addRole')->middleware('permission:Create a role');
        Route::put('role/update/{id}', 'updateRole')->middleware('permission:Update a role');
        Route::delete('role/delete/{id}', 'deleteRole')->middleware('permission:Delete a role');
//        Route::get('role/permissions/{role}','getPermissionsByRoleName')->middleware('permission:List of roles');
    });

    Route::controller(UserController::class)->group(function(){
        Route::get('user/index','indexUser')->middleware('permission:List of users');
        Route::get('user/{id}', 'showUser')->middleware('permission:Search user by ID');
        Route::post('user/add', 'createUser')->middleware('permission:Create an user');
        Route::put('user/update/{id}', 'updateUser')->middleware('permission:Update an user');
        Route::delete('user/delete/{id}', 'deleteUser')->middleware('permission:Delete an user');
        Route::get('user/role/{name}', 'indexUserByRole')->middleware('permission:Search instructor user');
    });

    Route::controller(RoleHasPermissionController::class)->group(function(){
        Route::get('role_permission/index','indexRoleHasPermission')->middleware('permission:List of roles and permissions');
        Route::get('role_permission/{id}','showPermissionsByRoleId')->middleware('permission:List of permissions by role ID');
        Route::put('role_permission/add/{id}','assignPermissionToRoleByRoleId')->middleware('permission:Assign permission to a role');
        Route::delete('role_permission/delete/{id}','deletePermissionToRoleByRoleId')->middleware('permission:Delete permission to a role');
    });



    Route::controller(UserHasRoleController::class)->group(function(){
        Route::get('user_role/index','indexUserHasRole')->middleware('permission:List of user and roles');
        Route::get('user_role/{id}','showUserHasRole')->middleware('permission:List of roles by user ID');
        Route::put('user_role/add/{id}','assignUserHasRole')->middleware('permission:Assign role to a user');
        Route::delete('user_role/delete/{id}','deleteUserHasRole')->middleware('permission:Delete role to a user');
    });

    Route::controller(UserHasPermissionController::class)->group(function(){
        Route::get('user_permission/index','indexUserHasPermission')->middleware('permission:List of users and permissions');
        Route::get('user_permission/{id}','showPermissionsByUserId')->middleware('permission:List of permissions by user ID');
        Route::put('user_permission/add/{id}','assignPermissionToUserById')->middleware('permission:Assign permission to a user');
        Route::delete('user_permission/delete/{id}','deletePermissionToUserById')->middleware('permission:Delete permission to a user');
    });
    //end access control

    //start nomenclature tables
    Route::controller(CampusController::class)->group(function(){
        Route::get('campus/index','indexCampus')->middleware('permission:List of campuses');
        Route::get('campus/{id}', 'showCampus')->middleware('permission:Search campus by ID');
        Route::get('campus/status/{status}', 'showCampusByStatus')->middleware('permission:Search campuses by status');
        Route::post('campus/add', 'addCampus')->middleware('permission:Create a campus');
        Route::put('campus/update/{id}', 'updateCampus')->middleware('permission:Update a campus');
        Route::delete('campus/delete/{id}', 'deleteCampus')->middleware('permission:Delete a campus');
    });

    Route::controller(CollegeController::class)->group(function(){
        Route::get('college/index','indexCollege')->middleware('permission:List of colleges');
        Route::get('college/{id}', 'showCollege')->middleware('permission:Search college by ID');
        Route::get('college/status/{status}', 'showCollegeByStatus')->middleware('permission:Search colleges by status');
        Route::post('college/add', 'addCollege')->middleware('permission:Create a college');
        Route::put('college/update/{id}', 'updateCollege')->middleware('permission:Update a college');
        Route::delete('college/delete/{id}', 'deleteCollege')->middleware('permission:Delete a college');
    });

    Route::controller(DepartmentController::class)->group(function(){
        Route::get('department/index','indexDepartment')->middleware('permission:List of departments');
        Route::get('department/{id}', 'showDepartment')->middleware('permission:Search department by ID');
        Route::get('department/status/{status}', 'showDepartmentByStatus')->middleware('permission:Search departments by status');
        Route::post('department/add', 'addDepartment')->middleware('permission:Create a department');
        Route::put('department/update/{id}', 'updateDepartment')->middleware('permission:Update a department');
        Route::delete('department/delete/{id}', 'deleteDepartment')->middleware('permission:Delete a department');
    });

    Route::controller(BuildingController::class)->group(function(){
        Route::get('building/index','indexBuilding')->middleware('permission:List of buildings');
        Route::get('building/{id}', 'showBuilding')->middleware('permission:Search building by ID');
        Route::get('building/status/{status}', 'showBuildingByStatus')->middleware('permission:Search buildings by status');
        Route::post('building/add', 'addBuilding')->middleware('permission:Create a building');
        Route::put('building/update/{id}', 'updateBuilding')->middleware('permission:Update a building');
        Route::delete('building/delete/{id}', 'deleteBuilding')->middleware('permission:Delete a building');
    });

    Route::controller(FacilityController::class)->group(function(){
        Route::get('facility/index','indexFacility')->middleware('permission:List of facilities');
        Route::get('facility/{id}', 'showFacility')->middleware('permission:Search facility by ID');
        Route::get('facility/status/{status}', 'showFacilityByStatus')->middleware('permission:Search facilities by status');
        Route::post('facility/add', 'addFacility')->middleware('permission:Create a facility');
        Route::put('facility/update/{id}', 'updateFacility')->middleware('permission:Update a facility');
        Route::delete('facility/delete/{id}', 'deleteFacility')->middleware('permission:Delete a facility');
    });
    //end nomenclature tables

    //start schedule module
    Route::controller(TermController::class)->group(function(){
        Route::get('term/index','indexTerm')->middleware('permission:List of terms');
        Route::get('term/{id}', 'showTerm')->middleware('permission:Search term by ID');
        Route::get('term/status/{status}', 'showTermByStatus')->middleware('permission:Search terms by status');
        Route::post('term/add', 'addTerm')->middleware('permission:Create a term');
        Route::put('term/update/{id}', 'updateTerm')->middleware('permission:Update a term');
        Route::delete('term/delete/{id}', 'deleteTerm')->middleware('permission:Delete a term');
    });

    Route::controller(ProgramLevelController::class)->group(function(){
        Route::get('program_level/index','indexProgramLevel')->middleware('permission:List of program levels');
        Route::get('program_level/{id}', 'showProgramLevel')->middleware('permission:Search program level by ID');
        Route::get('program_level/status/{status}', 'showProgramLevelByStatus')->middleware('permission:Search program levels by status');
        Route::post('program_level/add', 'addProgramLevel')->middleware('permission:Create a program level');
        Route::put('program_level/update/{id}', 'updateProgramLevel')->middleware('permission:Update a program level');
        Route::delete('program_level/delete/{id}', 'deleteProgramLevel')->middleware('permission:Delete a program level');
    });

    Route::controller(ProgramGroupingController::class)->group(function(){
        Route::get('program_grouping/index','indexProgramGrouping')->middleware('permission:List of program groupings');
        Route::get('program_grouping/{id}', 'showProgramGrouping')->middleware('permission:Search program grouping by ID');
        Route::get('program_grouping/status/{status}', 'showProgramGroupingByStatus')->middleware('permission:Search programs grouping by status');
        Route::post('program_grouping/add', 'addProgramGrouping')->middleware('permission:Create a program grouping');
        Route::put('program_grouping/update/{id}', 'updateProgramGrouping')->middleware('permission:Update a program grouping');
        Route::delete('program_grouping/delete/{id}', 'deleteProgramGrouping')->middleware('permission:Delete a program grouping');
    });

    Route::controller(ProgramController::class)->group(function(){
        Route::get('program/index','indexProgram')->middleware('permission:List of programs');
        Route::get('program/{id}', 'showProgram')->middleware('permission:Search program by ID');
        Route::get('program/status/{status}', 'showProgramByStatus')->middleware('permission:Search programs by status');
        Route::get('program/code/{code}', 'existProgramCode')->middleware('permission:Exist program by code');
        Route::post('program/add', 'addProgram')->middleware('permission:Create a program');
        Route::put('program/update/{id}', 'updateProgram')->middleware('permission:Update a program');
        Route::delete('program/delete/{id}', 'deleteProgram')->middleware('permission:Delete a program');
    });

    Route::controller(CourseController::class)->group(function(){
        Route::get('course/index','indexCourse')->middleware('permission:List of courses');
        Route::get('course/{id}', 'showCourse')->middleware('permission:Search course by ID');
        Route::get('course/find/{value}', 'findByValue')->middleware('permission:Search course by ID');
        Route::get('course/status/{status}', 'showCourseByStatus')->middleware('permission:Search courses by status');
        Route::post('course/add', 'addCourse')->middleware('permission:Create a course');
        Route::put('course/update/{id}', 'updateCourse')->middleware('permission:Update a course');
        Route::delete('course/delete/{id}', 'deleteCourse')->middleware('permission:Delete a course');
    });

    Route::controller(SessionController::class)->group(function(){
        Route::get('session/index','indexSession')->middleware('permission:List of sessions');
        Route::get('session/{id}', 'showSession')->middleware('permission:Search session by ID');
        Route::get('session/status/{status}', 'showSessionByStatus')->middleware('permission:Search sessions by status');
        Route::post('session/add', 'addSession')->middleware('permission:Create a session');
        Route::put('session/update/{id}', 'updateSession')->middleware('permission:Update a session');
        Route::delete('session/delete/{id}', 'deleteSession')->middleware('permission:Delete a session');
    });

    Route::controller(InstructorModeController::class)->group(function(){
        Route::get('instructor_mode/index','indexInstructorMode')->middleware('permission:List of instructor modes');
        Route::get('instructor_mode/{id}', 'showInstructorMode')->middleware('permission:Search instructor mode by ID');
        Route::get('instructor_mode/status/{status}','showInstructorModeByStatus')->middleware('permission:Search instructor modes by status');
        Route::post('instructor_mode/add', 'addInstructorMode')->middleware('permission:Create an instructor mode');
        Route::put('instructor_mode/update/{id}','updateInstructorMode')->middleware('permission:Update an instructor mode');
        Route::delete('instructor_mode/delete/{id}','deleteInstructorMode')->middleware('permission:Delete an instructor mode');
    });

    Route::controller(MeetingPatternController::class)->group(function(){
        Route::get('meeting_pattern/index','indexMeetingPattern')->middleware('permission:List of meeting pattern');
        Route::get('meeting_pattern/{day}/{hour}/{room_id}','showMeetingPattern')->middleware('permission:Search meeting pattern by day, hour, facility ID');
        Route::post('meeting_pattern/add', 'addMeetingPattern')->middleware('permission:Create a meeting pattern');
        Route::put('meeting_pattern/update/{day}/{hour}/{room_id}','updateMeetingPattern')->middleware('permission:Update a meeting pattern');
        Route::delete('meeting_pattern/delete/{day}/{hour}/{room_id}','deleteMeetingPattern')->middleware('permission:Delete a meeting pattern');
    });

    Route::controller(AccessPeriodController::class)->group(function(){
        Route::get('access_period/index','indexAccessPeriod')->middleware('permission:List of access periods');
        Route::get('access_period/{id}', 'showAccessPeriod')->middleware('permission:Search access period by ID');
        Route::post('access_period/add', 'addAccessPeriod')->middleware('permission:Create an access period');
        Route::put('access_period/update/{id}', 'updateAccessPeriod')->middleware('permission:Update an access period');
        Route::delete('access_period/delete/{id}', 'deleteAccessPeriod')->middleware('permission:Delete an access period');
    });

    Route::controller(SectionController::class)->group(function(){
        Route::get('section/index','indexSection')->middleware('permission:List of sections');
        Route::get('section/{id}', 'showSection')->middleware('permission:Search section by ID');
        Route::get('section/graph/quantity','quantitySection')->middleware('permission:List of sections');
        Route::get('section/info/sections','getTermsInfo')->middleware('permission:List of sections');
        Route::post('section/add', 'addSection')->middleware('permission:Search sections by status');
        Route::post('section/duplicate', 'duplicateSections')->middleware('permission:Duplicate a section');
        Route::put('section/update/{id}', 'updateSection')->middleware('permission:Create a section');
        Route::delete('section/delete/{id}', 'deleteSection')->middleware('permission:Update a section');
    });

});


