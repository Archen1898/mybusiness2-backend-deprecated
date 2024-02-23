<?php

return [
    //messages errors global
    'exception' => "Sorry, something is wrong. Please try again.",
    'requestException' => "The data entered is incorrect.",

    //messages errors model user
    'user.exceptionNotFoundAll' => "We couldn't find registered users.",
    'user.exceptionNotFoundById' => "We couldn't find a user with that id.",

    //messages errors model campus
    'campus.exceptionNotFoundByStatus' => "We could not find campuses registered with that status.",
    'campus.exceptionNotFoundAll' => "We couldn't find registered campuses.",
    'campus.exceptionNotFoundById' => "We couldn't find a campus with that id.",

    //messages errors model term
    'term.exceptionNotFoundByStatus' => "We could not find terms registered with that status.",
    'term.exceptionNotFoundAll' => "We couldn't find registered terms.",
    'term.exceptionNotFoundById' => "We couldn't find a term with that id.",

    //messages errors model program level
    'programLevel.exceptionNotFoundByStatus' => "We could not find program levels registered with that status.",
    'programLevel.exceptionNotFoundAll' => "We couldn't find registered program levels.",
    'programLevel.exceptionNotFoundById' => "We couldn't find a program level with that id.",

    //messages errors model program grouping
    'programGrouping.exceptionNotFoundByStatus' => "We could not find program groupings registered with that status.",
    'programGrouping.exceptionNotFoundAll' => "We couldn't find registered program groupings.",
    'programGrouping.exceptionNotFoundById' => "We couldn't find a program grouping with that id.",

    //messages errors model program
    'program.exceptionNotFoundByStatus' => "We could not find programs registered with that status.",
    'program.exceptionNotFoundAll' => "We couldn't find registered programs.",
    'program.exceptionNotFoundById' => "We couldn't find a program with that id.",
    'program.exceptionNotFoundByCode' => "We couldn't find a program with that code.",

    //messages errors model college
    'college.exceptionNotFoundByStatus' => "We could not find colleges registered with that status.",
    'college.exceptionNotFoundAll' => "We couldn't find registered colleges.",
    'college.exceptionNotFoundById' => "We couldn't find a college with that id.",

    //messages errors model department
    'department.exceptionNotFoundByStatus' => "We could not find departments registered with that status.",
    'department.exceptionNotFoundAll' => "We couldn't find registered departments.",
    'department.exceptionNotFoundById' => "We couldn't find a department with that id.",

    //messages errors model course
    'course.exceptionNotFoundByStatus' => "We could not find courses registered with that status.",
    'course.exceptionNotFoundAll' => "We couldn't find registered courses.",
    'course.exceptionNotFoundById' => "We couldn't find a course with that id.",

    //messages errors model building
    'building.exceptionNotFoundByStatus' => "We could not find buildings registered with that status.",
    'building.exceptionNotFoundAll' => "We couldn't find registered buildings.",
    'building.exceptionNotFoundById' => "We couldn't find a building with that id.",

    //messages errors model facility
    'facility.exceptionNotFoundByStatus' => "We could not find facilities registered with that status.",
    'facility.exceptionNotFoundAll' => "We couldn't find registered facilities.",
    'facility.exceptionNotFoundById' => "We couldn't find a facility with that id.",


    //messages errors model session
    'session.exceptionNotFoundByStatus' => "We could not find sessions registered with that status.",
    'session.exceptionNotFoundAll' => "We couldn't find registered sessions.",
    'session.exceptionNotFoundById' => "We couldn't find a session with that id.",

    //messages errors model instructorModes
    'instructorMode.exceptionNotFoundByStatus' => "We could not find instructor modes registered with that status.",
    'instructorMode.exceptionNotFoundAll' => "We couldn't find registered instructor modes.",
    'instructorMode.exceptionNotFoundById' => "We couldn't find an instructor mode with that id.",

    //messages errors model instructor modes
    'meetingPattern.exceptionNotFoundAll' => "We couldn't find registered meeting patterns.",
    'meetingPattern.exceptionNotFoundByDayHourFacility' => "We couldn't find an meeting pattern with that day, hour and facility.",

    //messages errors model access period
    'accessPeriod.exceptionNotFoundAll' => "We couldn't find registered access periods.",
    'accessPeriod.exceptionNotFoundById' => "We couldn't find an access period with that id.",

    //messages errors model section
    'section.exceptionNotFoundByStatus' => "We could not find sections registered with that status.",
    'section.exceptionNotFoundAll' => "We couldn't find registered sections.",
    'section.exceptionNotFoundById' => "We couldn't find an section with that id.",

    //messages errors model permission
    'permission.exceptionNotFoundByStatus' => "We could not find permissions registered with that status.",
    'permission.exceptionNotFoundAll' => "We couldn't find registered permissions.",
    'permission.exceptionNotFoundById' => "We couldn't find an permission with that id.",

    //messages errors model role
    'role.exceptionNotFoundAll' => "We couldn't find registered roles.",
    'role.exceptionNotFoundById' => "We couldn't find an role with that id.",

    //messages errors model role has permissions
    'roleHasPermission.exceptionNotFoundAll' => "We couldn't find roles with registered permissions.",
    'roleHasPermission.exceptionNotFoundById' => "We couldn't find a role with that id.",
    'roleHasPermission.syncPermissionsOk' => "Permissions successfully assigned.",
    'roleHasPermission.syncPermissionsWrong' => "It was not possible to assign permissions to the selected role.",
    'roleHasPermission.revokePermissionsOk' => "Permissions successfully revoked.",
    'roleHasPermission.revokePermissionsWrong' => "It was not possible to revoke permissions to the selected role.",

    //messages errors model user has permissions
    'userHasPermission.exceptionNotFoundAll' => "We couldn't find users with registered permissions.",
    'userHasPermission.exceptionNotFoundById' => "We couldn't find an user with that id.",
    'userHasPermission.syncPermissionsOk' => "Permissions successfully assigned.",
    'userHasPermission.syncPermissionsWrong' => "It was not possible to assign permissions to the selected user.",
    'userHasPermission.revokePermissionsOk' => "Permissions successfully revoked.",
    'userHasPermission.revokePermissionsWrong' => "It was not possible to revoke permissions to the selected user.",

    //messages errors model user has roles
    'userHasRole.exceptionNotFoundAll' => "We couldn't find users with registered roles.",
    'userHasRole.exceptionNotFoundById' => "We couldn't find an user with that id.",
    'userHasRole.syncRolesOk' => "Roles successfully assigned.",
    'userHasRole.syncRolesWrong' => "It was not possible to assign roles to the selected user.",
    'userHasRole.revokeRolesOk' => "Roles successfully revoked.",
    'userHasRole.revokeRolesWrong' => "It was not possible to revoke roles to the selected user.",
];
