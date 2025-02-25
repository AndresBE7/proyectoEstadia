<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\ClassTeacherController;
use App\Http\Controllers\ClassTimetableController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes a re loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
  //  return view('welcome');
//});

Route::get('/', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'AuthLogin']);
Route::get('logout', [AuthController::class, 'logout']);
Route::get('forgot-password', [AuthController::class, 'forgotpassword']);
Route::post('forgot-password', [AuthController::class, 'PostForgotPassword']);
Route::get('reset/{token}', [AuthController::class, 'reset']);
Route::post('reset/{token}', [AuthController::class, 'PostReset']);


  //Enlace de ruta para ingresar a dashboard de administrador 
  Route::group(['middleware' => 'admin'], function (){
  Route::get('/admin/dashboard', [DashboardController::class, 'dashboard']);
  Route::get('/admin/admin/list', [AdminController::class, 'list']);
  Route::get('/admin/admin/add', [AdminController::class, 'add']);
  Route::post('/admin/admin/insert', [AdminController::class, 'insert']);
  Route::get('/admin/admin/edit/{id}', [AdminController::class, 'edit']);
  Route::post('/admin/admin/edit/{id}', [AdminController::class, 'update']);
  Route::get('/admin/admin/delete/{id}', [AdminController::class, 'delete']);

  //Enlance de rutas para los tutores
  Route::get('/admin/parent/list', [ParentController::class, 'list'])->name('admin.parent.list');
  Route::get('/admin/parent/add', [ParentController::class, 'add'])->name('admin.parent.add');
  Route::post('/admin/parent/insert', [ParentController::class, 'insert'])->name('admin.parent.insert');
  Route::get('/admin/parent/edit/{id}', [ParentController::class, 'edit'])->name('admin.parent.edit');
  Route::post('/admin/parent/update/{id}', [ParentController::class, 'update'])->name('admin.parent.update');
  Route::get('/admin/parent/delete/{id}', [ParentController::class, 'delete'])->name('admin.parent.delete');
  Route::get('/admin/parent/my-student/{id}', [ParentController::class, 'myStudent'])->name('admin.parent.myStudent');
  Route::get('admin/parent/assign-student-parent/{student_id}', [ParentController::class, 'assignStudentParent'])->name('admin.parent.AssignStudentParent');

  // Enlace de rutas para los profesores
  Route::get('/admin/teacher/list', [TeacherController::class, 'list'])->name('admin.teacher.list');
  Route::get('/admin/teacher/add', [TeacherController::class, 'add'])->name('admin.teacher.add');
  Route::post('/admin/teacher/insert', [TeacherController::class, 'insert'])->name('admin.teacher.insert');
  Route::get('/admin/teacher/edit/{id}', [TeacherController::class, 'edit'])->name('admin.teacher.edit');
  Route::patch('/admin/teacher/update/{id}', [TeacherController::class, 'update'])->name('admin.teacher.update');
  Route::delete('/admin/teacher/delete/{id}', [TeacherController::class, 'delete'])->name('admin.teacher.delete');

  //Enlance de rutas para las clases
  Route::get('/admin/class/list', [ClassController::class, 'list']);
  Route::get('/admin/class/add', [ClassController::class, 'add']);
  Route::post('/admin/class/insert', [ClassController::class, 'insert']);
  Route::get('/admin/class/edit/{id}', [ClassController::class, 'edit']);
  Route::post('/admin/class/update/{id}', [ClassController::class, 'update']);
  Route::get('/admin/class/delete/{id}', [ClassController::class, 'delete']);
  Route::get('admin/class/students/{id}', [ClassController::class, 'students']);


  //Enlance de rutas para las materias
  Route::get('/admin/subject/list', [SubjectController::class, 'list']);
  Route::get('/admin/subject/add', [SubjectController::class, 'add']);
  Route::post('/admin/subject/insert', [SubjectController::class, 'insert']);
  Route::get('/admin/subject/edit/{id}', [SubjectController::class, 'edit']);
  Route::put('/admin/subject/update/{id}', [SubjectController::class, 'update']);
  Route::get('/admin/subject/delete/{id}', [SubjectController::class, 'delete']);

// Rutas para documentos (admin)
Route::get('/admin/documents/list', [DocumentController::class, 'list']);
Route::get('/admin/documents/add', [DocumentController::class, 'add']);
Route::post('/admin/documents/insert', [DocumentController::class, 'insert']);
Route::get('/admin/documents/edit/{id}', [DocumentController::class, 'edit']);
Route::post('/admin/documents/update/{id}', [DocumentController::class, 'update']);
Route::get('/admin/documents/delete/{id}', [DocumentController::class, 'delete']);
Route::get('/admin/documents/download/{id}', [DocumentController::class, 'downloadDocument']);

// Ruta para estudiantes
Route::get('/student/documents/show', [DocumentController::class, 'documentShow'])->name('student.documents.show');

  // Enlace de rutas para los estudiantes desde admin
  Route::get('/admin/student/list', [StudentController::class, 'list'])->name('admin.student.list');
  Route::get('/admin/student/add', [StudentController::class, 'add'])->name('admin.student.add');
  Route::post('/admin/student/insert', [StudentController::class, 'insert'])->name('admin.student.insert');
  Route::get('/admin/student/edit/{id}', [StudentController::class, 'edit'])->name('admin.student.edit');
  Route::post('/admin/student/update/{id}', [StudentController::class, 'update'])->name('admin.student.update');
  Route::put('/admin/student/update/{id}', [StudentController::class, 'update'])->name('student.update');
  Route::get('/admin/student/delete/{id}', [StudentController::class, 'delete']);

  //Enlace de rutas para asignar materias
  Route::get('/admin/assign_subject/list', [ClassSubjectController::class, 'list']);
  Route::get('/admin/assign_subject/add', [ClassSubjectController::class, 'add']);
  Route::post('/admin/assign_subject/insert', [ClassSubjectController::class, 'insert']);
  Route::get('/admin/assign_subject/edit/{id}', [ClassSubjectController::class, 'edit']);
  Route::post('/admin/assign_subject/update/{id}', [ClassSubjectController::class, 'update']);
  Route::delete('/admin/assign_subject/delete/{id}', [ClassSubjectController::class, 'delete'])->name('admin.assign_subject.delete');

  // Enlace de rutas para asignar maestros
  Route::get('/admin/assign_teacher/list', [ClassTeacherController::class, 'list']);
  Route::get('/admin/assign_teacher/add', [ClassTeacherController::class, 'add']);
  Route::post('/admin/assign_teacher/insert', [ClassTeacherController::class, 'insert']);
  Route::get('/admin/assign_teacher/edit/{id}', [ClassTeacherController::class, 'edit']);
  Route::post('/admin/assign_teacher/update/{id}', [ClassTeacherController::class, 'update']);
  Route::delete('/admin/assign_teacher/delete/{id}', [ClassTeacherController::class, 'delete'])->name('admin.assign_teacher.delete');

  //Enlaces para cambiar la contraseña 
  Route::get('/admin/change_password', [UserController::class, 'change_password'])->name('change.password');
  Route::post('/admin/change_password', [UserController::class, 'update_change_password']);


  //Enlaces para la descarga de la base de datos - Solo admins
  Route::post('/admin/backup/create', [BackupController::class, 'createBackup'])->name('backup.create');
  Route::post('/admin/backup/restore', [BackupController::class, 'restoreBackup'])->name('backup.restore');
  Route::get('/admin/backup/index', [BackupController::class, 'index'])->name('admin.backup.index');
  Route::get('/admin/backup/download/{filename}', [BackupController::class, 'download'])->name('admin.backup.download');


    Route::get('admin/surveys/index', [SurveyController::class, 'index']);
    Route::get('/admin/surveys/create', [SurveyController::class, 'create'])->name('admin.surveys.create');
    Route::post('/admin/surveys', [SurveyController::class, 'store'])->name('admin.surveys.store');
    Route::post('/admin/surveys/{id}/activate', [SurveyController::class, 'activate'])->name('admin.surveys.activate');
    Route::delete('/admin/surveys/{id}', [SurveyController::class, 'destroy'])->name('admin.surveys.destroy');
    Route::post('admin/surveys/{survey}/activate', [SurveyController::class, 'activate'])->name('admin.surveys.activate');
    Route::get('/admin/surveys/{survey}/results/user/{user}', 'App\Http\Controllers\SurveyController@userResponses')->name('admin.surveys.user-responses');

});

Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
  Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
  Route::get('/surveys/create', [SurveyController::class, 'create'])->name('surveys.create');
  Route::post('/surveys', [SurveyController::class, 'store'])->name('surveys.store');
  Route::get('/surveys/{survey}/edit', [SurveyController::class, 'edit'])->name('surveys.edit');
  Route::put('/surveys/{survey}', [SurveyController::class, 'update'])->name('surveys.update');
  Route::delete('/surveys/{survey}', [SurveyController::class, 'destroy'])->name('surveys.destroy');
  Route::post('/surveys/{survey}/activate', [SurveyController::class, 'activate'])->name('surveys.activate');
  Route::get('/surveys/{survey}/results', [SurveyController::class, 'results'])->name('surveys.results');
});

// Mostrar el formulario para responder la encuesta
Route::get('/surveys/{survey}/respond', [SurveyController::class, 'showRespondForm'])
    ->name('surveys.respond');

// Procesar las respuestas
Route::post('/surveys/{survey}/submit', [SurveyController::class, 'submit'])
    ->name('surveys.submit');

    Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
    Route::get('/surveys/{id}/respond', [SurveyController::class, 'respond'])->name('surveys.respond');
    Route::post('/surveys/{id}/submit', [SurveyController::class, 'submit'])->name('surveys.submit');
    Route::get('/surveys/{id}', [SurveyController::class, 'show'])->name('surveys.show');



    Route::group(['middleware' => 'common'], function () {
      Route::get('chat', [ChatController::class, 'chat']);
      Route::post('/submit_message', [ChatController::class, 'submit_message'])->name('submit_message');
  });
  
  Route::get('/MensajeNoLeido', [ChatController::class, 'seeMessage'])->name('seeMessage');
  

Route::get('/calendar', [CalendarController::class, 'school_calendar'])->name('calendar.index');
Route::post('/calendar/store', [CalendarController::class, 'store_event'])->name('calendar.store_event');
Route::delete('/calendar/delete/{id}', [CalendarController::class, 'delete_event'])->name('calendar.delete');

//Enlace de ruta para ingresar a dashboard de maestro 
Route::group(['middleware' => 'maestro'], function (){
  Route::get('/teacher/dashboard', [DashboardController::class, 'dashboard']);

  
  //Enlaces para cambiar la contraseña 
  Route::get('/teacher/change_password', [UserController::class, 'change_password']);
  Route::post('/teacher/update_change_password', [UserController::class, 'update_change_password']);
});

//Enlace de ruta para ingresar a dashboard de alumno 
  Route::group(['middleware' => 'alumno'], function (){
  Route::get('/student/dashboard', [DashboardController::class, 'dashboard']);

  Route::get('/student/surveys/{survey}', [SurveyController::class, 'show'])->name('students.surveys.show');
  Route::post('/student/surveys/{survey}/submit', [SurveyController::class, 'submitResponse'])->name('students.surveys.submit');
  Route::get('/student/documents/show', [StudentController::class, 'documentShow'])->name('student.documents.document_show');
  Route::get('/student/documents/show', [DocumentController::class, 'documentShow'])->name('student.documents.show');
  
  //Enlaces para cambiar la contraseña 
  Route::get('/student/change_password', [UserController::class, 'change_password']);
  Route::post('/student/update_change_password', [UserController::class, 'update_change_password']);

  Route::group(['middleware' => 'alumno'], function () {

});
});

Route::middleware(['auth'])->group(function () {
  Route::get('/student/documents/show', [DocumentController::class, 'documentShow'])->name('student.documents.show');
  Route::get('/student/documents/download/{id}', [DocumentController::class, 'downloadDocument'])->name('student.documents.download');
  
});

//Enlace de ruta para ingresar a dashboard de tutor 
  Route::group(['middleware' => 'tutor'], function (){
  Route::get('/parent/dashboard', [DashboardController::class, 'dashboard']);

  //Rutas para Mi estudiante
  Route::get('/parent/my_student', [ParentController::class, 'myStudent'])->name('parent.my_student');

  //Enlaces para cambiar la contraseña 
  Route::get('/parent/change_password', [UserController::class, 'change_password']);
  Route::post('/parent/update_change_password', [UserController::class, 'update_change_password']);
});