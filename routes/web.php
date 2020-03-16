<?php

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

//clear bo nho tam
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');

    return 'DONE'; //Return anything
});


Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::get('/', function () {
        return redirect()->route('home');
    });
    Route::get('home', function () {
        return redirect()->route('home');
    });

    
    // dashbroad
    Route::get('Dashbroad', 'thionline\dashbroad\dashbroadController@index')->name('home');
    

    
    // question
    Route::get('question-list.html', ['middleware' => ['permission:question_list'],
        'as' => 'question.list', 
        'uses' => 'thionline\question\questionController@question_list'
    ]);
    Route::post('question-handling_ajax_create', [
        'as' => 'question.handling_ajax_create', 
        'uses' => 'thionline\question\questionController@question_store'
   
    ]);
    Route::get('question-handling_ajax_create', function(){
        return redirect()->route('home');
    });
    Route::get('question-handling_ajax_question', [//ajax load danh sach câu hỏi
        'as' => 'question.handling_ajax_question', 
        'uses' => 'thionline\question\questionController@handling_ajax_question'   
    ]);

    
    // Exam thi
    // Danh sach de thi
    Route::get('exam.list.html', ['middleware' => ['permission:exam_list'],
        'as' => 'exam.list', 
        'uses' => 'thionline\exam\examController@exam_list'
    ]);  
    //load danh sach cau hoi theo chu de de tạo cau hoi
    Route::get('question-handling_ajax_topic', [//ajax
        'as' => 'question.topic.handling_ajax', 
        'uses' => 'thionline\exam\examController@handling_ajax_question_topic_datatable'
    ]);
    Route::get('exam-handling_ajax_exam', [//ajax load danh sách câu hoi
        'as' => 'exam.handling_ajax_exam', 
        'uses' => 'thionline\exam\examController@handling_ajax_exam_datatable'
    ]);
    //chọn đề đe thi -exam_test
    Route::get('exam-choose.html', ['middleware' => ['permission:exam_test'],
        'as' => 'exam.choose', 
        'uses' => 'thionline\exam\examController@exam_choose'
    ]);  
    // load chi tiet  de thi vao thi ajax
    Route::post('exam-choose_test.html', [
        'as' => 'exam.choose_test_ajax', 
        'uses' => 'thionline\exam\examController@exam_choose_test'
    ]); 
    Route::get('exam-choose_test.html', function(){
        return redirect()->route('home');
    });
    //nopbaithi
    Route::post('exam-choose_test_submit.html', [
        'as' => 'exam.choose_test_submit', 
        'uses' => 'thionline\exam\examController@exam_update'//nopbaithi
    ]);  
    Route::get('exam-choose_test_submit.html', function(){
        return redirect()->route('home');
    });

    Route::post('exam-haddings', [
        'as' => 'exam.haddings', 
        'uses' => 'thionline\exam\examController@hadding_exam'//xy ly yeu cau cua ba thi(load bang tong hop nguoi thi của một bài thi)
    ]); 
    Route::get('exam-haddings', function(){
        return redirect()->route('home');
    });

    //Route::get('export_exam_user/{id_exam}', 'thionline\exam\examController@export_exam');

    Route::get('export_exam_user',[
        'as' => 'exam_export', 
        'uses' => 'thionline\exam\examController@export_exam'
    ]);

    Route::get('export_exam_user_detail',[ //load chi tiet bai thi theo tung id ket qua de thi
        'as' => 'exam_export.detail', 
        'uses' => 'thionline\exam\examController@export_exam_detail'
    ]);
    

        //Thêm đề thi
    Route::post('question-handling_ajax_topic_create', [
        'as' => 'question.topic.handling_ajax_create', 
        'uses' => 'thionline\exam\examController@handling_ajax_question_topic_create'
    ]);
    Route::get('question-handling_ajax_topic_create', function(){
        return redirect()->route('home');
    });





    
    // user-
    Route::get('user.list.html', ['middleware' => ['permission:system_user_list'],//danh sach user
        'as' => 'users.list', 
        'uses' => 'thionline\user\userController@user_list'
    ]);
    Route::get('user.detail.html', [//chitiet ussre o giao dien cap nhat cua tung user
        'as' => 'users.detail', 
        'uses' => 'thionline\user\userController@user_detail'
    ]);
    Route::post('user.detail.html', [//chitiet ussre_luu 
        'as' => 'users.detail', 
        'uses' => 'thionline\user\userController@user_detail_store'
    ]);

    Route::get('/User.handling_ajax_user', ['middleware' => ['permission:system_user_list'], //ajax load danh sach user
        'as' => 'user.handling_ajax_user', 
        'uses' => 'thionline\user\userController@handling_ajax_user'
    ]);
    Route::get('user-add.html', [ 'middleware' => ['permission:system-add_user'], //load form add user system-add_user
        'as' => 'users.add', 
        'uses' => 'thionline\user\userController@user_add'
    ]);
    Route::post('user-add.html', [ 'middleware' => ['permission:system-add_user'],//luu thôn tin add nguoi dung
        'as' => 'users.store', 
        'uses' => 'thionline\user\userController@store_user'
    ]);

    Route::post('user-hadding', [//xu ly cac yeu cau nhuw, check email trung, load danh sach huyen, tinh,xa 
        'as' => 'users.hadding', 
        'uses' => 'thionline\user\userController@hadding_user'
    ]);
    Route::get('user-hadding', function(){
        return redirect()->route('home');
    });
  



});