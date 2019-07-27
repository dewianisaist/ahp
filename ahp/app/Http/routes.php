<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

Route::auth();

Route::group(['middleware' => ['auth']], function() {
	//profile_users - tidak ada permission
	Route::get('profile_users',['as'=>'profile_users.show','uses'=>'ProfileUserController@show']);
	Route::get('profile_users/edit',['as'=>'profile_users.edit','uses'=>'ProfileUserController@edit']);
	Route::patch('profile_users',['as'=>'profile_users.update','uses'=>'ProfileUserController@update']);

	//preferences - fix
	Route::get('preferences',['as'=>'preferences.index','uses'=>'PreferenceController@index']);
	Route::get('preferences/{id}/edit',['as'=>'preferences.edit','uses'=>'PreferenceController@edit']);
	Route::patch('preferences/{id}',['as'=>'preferences.update','uses'=>'PreferenceController@update']);
	Route::delete('preferences/{id}',['as'=>'preferences.destroy','uses'=>'PreferenceController@destroy']);

	//manage_alternatives - fix
	Route::get('manage_alternatives',['as'=>'manage_alternatives.index','uses'=>'ManageAlternativeController@index']);
	Route::get('manage_alternatives/create',['as'=>'manage_alternatives.create','uses'=>'ManageAlternativeController@create']);
	Route::post('manage_alternatives/create',['as'=>'manage_alternatives.store','uses'=>'ManageAlternativeController@store']);
	Route::get('manage_alternatives/{id}',['as'=>'manage_alternatives.show','uses'=>'ManageAlternativeController@show']);
	Route::get('manage_alternatives/{id}/edit',['as'=>'manage_alternatives.edit','uses'=>'ManageAlternativeController@edit']);
	Route::patch('manage_alternatives/{id}',['as'=>'manage_alternatives.update','uses'=>'ManageAlternativeController@update']);
	Route::delete('manage_alternatives/{id}',['as'=>'manage_alternatives.destroy','uses'=>'ManageAlternativeController@destroy']);

	//criteria - fix
	Route::get('criteria',['as'=>'criteria.index','uses'=>'CriteriaController@index']);
	Route::get('criteria/create',['as'=>'criteria.create','uses'=>'CriteriaController@create']);
	Route::post('criteria/create',['as'=>'criteria.store','uses'=>'CriteriaController@store']);
	Route::get('criteria/{id}/edit',['as'=>'criteria.edit','uses'=>'CriteriaController@edit']);
	Route::patch('criteria/{id}',['as'=>'criteria.update','uses'=>'CriteriaController@update']);
	Route::delete('criteria/{id}',['as'=>'criteria.destroy','uses'=>'CriteriaController@destroy']);
	Route::delete('criteria/{id}/sub',['as'=>'criteria.subdestroy','uses'=>'CriteriaController@subdestroy']);

	//weight - fix
	Route::get('weights',['as'=>'weights.index','uses'=>'WeightController@index']);
	Route::get('weights/{id}/pairwise',['as'=>'weights.pairwise','uses'=>'WeightController@create']);
	Route::patch('weights/{id}',['as'=>'weights.store','uses'=>'WeightController@store']);

	//result_selection - fix
	Route::get('score',['as'=>'score.index','uses'=>'ScoreController@index']);
	Route::get('score/{id}/assessment',['as'=>'score.assessment','uses'=>'ScoreController@assessment']);
	Route::patch('score/{id}',['as'=>'score.store','uses'=>'ScoreController@store']);
	Route::post('score/count',['as'=>'score.count','uses'=>'ScoreController@count']);

	//result - tidak ada permission
	Route::get('result',['as'=>'result.index','uses'=>'ResultController@index']);
});
