<?php

use Illuminate\Support\Facades\Session;
use App\Http\Helpers\AppHelper;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::group(['middleware' => 'role:admin'], function() {
//    Route::get('/admin', function() {
//        return 'Welcome Admin';
//    });
//});


/**
 * Admin panel routes goes below
 */
Route::group(
    ['namespace' => 'Backend', 'middleware' => ['guest']], function () {
    Route::get('/login', 'UserController@login')->name('login');
    Route::post('/login', 'UserController@authenticate');
    Route::get('/forgot', 'UserController@forgot')->name('forgot');
    Route::post('/forgot', 'UserController@forgot')
        ->name('forgot');
    Route::get('/reset/{token}', 'UserController@reset')
        ->name('reset');
    Route::post('/reset/{token}', 'UserController@reset')
        ->name('reset');

}
);

Route::get('/public/exam', 'Backend\ExamController@indexPublic')->name('public.exam_list');
Route::any('/online-result', 'Backend\ReportController@marksheetPublic')->name('report.marksheet_pub');

Route::group(
    ['namespace' => 'Backend', 'middleware' => ['auth', 'permission']], function () {
    Route::get('/logout', 'UserController@logout')->name('logout');
    Route::get('/lock', 'UserController@lock')->name('lockscreen');
    Route::get('/dashboard', 'UserController@dashboard')->name('user.dashboard');

    //user management
    Route::resource('user', 'UserController');
    Route::get('/profile', 'UserController@profile')
        ->name('profile');
    Route::post('/profile', 'UserController@profile')
        ->name('profile');
    Route::get('/change-password', 'UserController@changePassword')
        ->name('change_password');
    Route::post('/change-password', 'UserController@changePassword')
        ->name('change_password');
    Route::post('user/status/{id}', 'UserController@changeStatus')
        ->name('user.status');
    Route::any('user/{id}/permission', 'UserController@updatePermission')
        ->name('user.permission');

    //user notification
    Route::get('/notification/unread', 'NotificationController@getUnReadNotification')
        ->name('user.notification_unread');
    Route::get('/notification/read', 'NotificationController@getReadNotification')
        ->name('user.notification_read');
    Route::get('/notification/all', 'NotificationController@getAllNotification')
        ->name('user.notification_all');

    //system user management
    Route::get('/administrator/user', 'AdministratorController@userIndex')
        ->name('administrator.user_index');
    Route::get('/administrator/user/create', 'AdministratorController@userCreate')
        ->name('administrator.user_create');
    Route::post('/administrator/user/store', 'AdministratorController@userStore')
        ->name('administrator.user_store');
    Route::get('/administrator/user/{id}/edit', 'AdministratorController@userEdit')
        ->name('administrator.user_edit');
    Route::post('/administrator/user/{id}/update', 'AdministratorController@userUpdate')
        ->name('administrator.user_update');
    Route::post('/administrator/user/{id}/delete', 'AdministratorController@userDestroy')
        ->name('administrator.user_destroy');
    Route::post('administrator/user/status/{id}', 'AdministratorController@userChangeStatus')
        ->name('administrator.user_status');

    Route::any('/administrator/user/reset-password', 'AdministratorController@userResetPassword')
        ->name('administrator.user_password_reset');



    //user role manage
    Route::get('/role', 'UserController@roles')
        ->name('user.role_index');
    Route::post('/role', 'UserController@roles')
        ->name('user.role_destroy');
    Route::get('/role/create', 'UserController@roleCreate')
        ->name('user.role_create');
    Route::post('/role/store', 'UserController@roleCreate')
        ->name('user.role_store');
    Route::any('/role/update/{id}', 'UserController@roleUpdate')
        ->name('user.role_update');


    // application settings routes
    Route::get('settings/institute', 'SettingsController@institute')
        ->name('settings.institute');
    Route::post('settings/institute', 'SettingsController@institute')
        ->name('settings.institute');

    // academic calendar
    Route::get('settings/academic-calendar', 'SettingsController@academicCalendarIndex')
        ->name('settings.academic_calendar.index');
    Route::post('settings/academic-calendar', 'SettingsController@academicCalendarIndex')
        ->name('settings.academic_calendar.destroy');
    Route::get('settings/academic-calendar/create', 'SettingsController@academicCalendarCru')
        ->name('settings.academic_calendar.create');
    Route::post('settings/academic-calendar/create', 'SettingsController@academicCalendarCru')
        ->name('settings.academic_calendar.store');
    Route::get('settings/academic-calendar/edit/{id}', 'SettingsController@academicCalendarCru')
        ->name('settings.academic_calendar.edit');
    Route::post('settings/academic-calendar/update/{id}', 'SettingsController@academicCalendarCru')
        ->name('settings.academic_calendar.update');
    // administrator routes
    //academic year
    Route::get('administrator/academic_year', 'AdministratorController@academicYearIndex')
        ->name('administrator.academic_year');
    Route::post('administrator/academic_year', 'AdministratorController@academicYearIndex')
        ->name('administrator.academic_year_destroy');
    Route::get('administrator/academic_year/create', 'AdministratorController@academicYearCru')
        ->name('administrator.academic_year_create');
    Route::post('administrator/academic_year/create', 'AdministratorController@academicYearCru')
        ->name('administrator.academic_year_store');
    Route::get('administrator/academic_year/edit/{id}', 'AdministratorController@academicYearCru')
        ->name('administrator.academic_year_edit');
    Route::post('administrator/academic_year/update/{id}', 'AdministratorController@academicYearCru')
        ->name('administrator.academic_year_update');
    Route::post('administrator/academic_year/status/{id}', 'AdministratorController@academicYearChangeStatus')
        ->name('administrator.academic_year_status');

    // template
    //mail and sms
    // id card
    // academic routes
    // class
    Route::get('academic/class', 'AcademicController@classIndex')
        ->name('academic.class');
    Route::post('academic/class', 'AcademicController@classIndex')
        ->name('academic.class_destroy');
    Route::get('academic/class/create', 'AcademicController@classCru')
        ->name('academic.class_create');
    Route::post('academic/class/create', 'AcademicController@classCru')
        ->name('academic.class_store');
    Route::get('academic/class/edit/{id}', 'AcademicController@classCru')
        ->name('academic.class_edit');
    Route::post('academic/class/update/{id}', 'AcademicController@classCru')
        ->name('academic.class_update');
    Route::post('academic/class/status/{id}', 'AcademicController@classStatus')
        ->name('academic.class_status');

    // section
    Route::get('academic/section', 'AcademicController@sectionIndex')
        ->name('academic.section');
    Route::post('academic/section', 'AcademicController@sectionIndex')
        ->name('academic.section_destroy');
    Route::get('academic/section/create', 'AcademicController@sectionCru')
        ->name('academic.section_create');
    Route::post('academic/section/create', 'AcademicController@sectionCru')
        ->name('academic.section_store');
    Route::get('academic/section/edit/{id}', 'AcademicController@sectionCru')
        ->name('academic.section_edit');
    Route::post('academic/section/update/{id}', 'AcademicController@sectionCru')
        ->name('academic.section_update');
    Route::post('academic/section/status/{id}', 'AcademicController@sectionStatus')
        ->name('academic.section_status');

    // subject
    Route::get('academic/subject', 'AcademicController@subjectIndex')
        ->name('academic.subject');
    Route::post('academic/subject', 'AcademicController@subjectIndex')
        ->name('academic.subject_destroy');
    Route::get('academic/subject/create', 'AcademicController@subjectCru')
        ->name('academic.subject_create');
    Route::post('academic/subject/create', 'AcademicController@subjectCru')
        ->name('academic.subject_store');
    Route::get('academic/subject/edit/{id}', 'AcademicController@subjectCru')
        ->name('academic.subject_edit');
    Route::post('academic/subject/update/{id}', 'AcademicController@subjectCru')
        ->name('academic.subject_update');
    Route::post('academic/subject/status/{id}', 'AcademicController@subjectStatus')
        ->name('academic.subject_status');


    // teacher routes
    Route::resource('teacher', 'TeacherController');
    Route::post('teacher/status/{id}', 'TeacherController@changeStatus')
        ->name('teacher.status');

    // student routes
    Route::resource('student', 'StudentController');
    Route::post('student/status/{id}', 'StudentController@changeStatus')
        ->name('student.status');
    Route::get('student-list-by-filter', 'StudentController@studentListByFitler')
        ->name('student.list_by_fitler');

});