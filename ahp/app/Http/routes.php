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
	
	//registrants - tidak ada permission
	Route::get('registrants',['as'=>'registrants.index','uses'=>'RegistrantController@index']);
	Route::get('registrants/edit',['as'=>'registrants.edit','uses'=>'RegistrantController@edit']);
	Route::patch('registrants/',['as'=>'registrants.update','uses'=>'RegistrantController@update']);

	//contoh permission
	// Route::get('users',['as'=>'users.index','uses'=>'UserController@index','middleware' => ['permission:user-list|user-create|user-edit|user-delete']]);
	// Route::get('users/create',['as'=>'users.create','uses'=>'UserController@create','middleware' => ['permission:user-create']]);
	// Route::post('users/create',['as'=>'users.store','uses'=>'UserController@store','middleware' => ['permission:user-create']]);
	// Route::get('users/{id}',['as'=>'users.show','uses'=>'UserController@show']);
	// Route::get('users/{id}/edit',['as'=>'users.edit','uses'=>'UserController@edit','middleware' => ['permission:user-edit']]);
	// Route::patch('users/{id}',['as'=>'users.update','uses'=>'UserController@update','middleware' => ['permission:user-edit']]);
	// Route::delete('users/{id}',['as'=>'users.destroy','uses'=>'UserController@destroy','middleware' => ['permission:user-delete']]);

	//users - tidak ada permission
	Route::get('users',['as'=>'users.index','uses'=>'UserController@index']);	
	Route::get('users/create',['as'=>'users.create','uses'=>'UserController@create']);
	Route::post('users/create',['as'=>'users.store','uses'=>'UserController@store']);
	Route::get('users/{id}',['as'=>'users.show','uses'=>'UserController@show']);
	Route::get('users/{id}/edit',['as'=>'users.edit','uses'=>'UserController@edit']);
	Route::patch('users/{id}',['as'=>'users.update','uses'=>'UserController@update']);
	Route::delete('users/{id}',['as'=>'users.destroy','uses'=>'UserController@destroy']);

	//roles - tidak ada permission
	Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index']);
	Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create']);
	Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store']);
	Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
	Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit']);
	Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update']);
	Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy']);

	//profile_users - tidak ada permission
	Route::get('profile_users',['as'=>'profile_users.show','uses'=>'ProfileUserController@show']);
	Route::get('profile_users/edit',['as'=>'profile_users.edit','uses'=>'ProfileUserController@edit']);
	Route::patch('profile_users',['as'=>'profile_users.update','uses'=>'ProfileUserController@update']);
	
	//selections - ada permission
	Route::get('selections',['as'=>'selections.index','uses'=>'SelectionController@index','middleware' => ['permission:selection-list|selection-edit']]);
	Route::get('selections/{id}',['as'=>'selections.show','uses'=>'SelectionController@show']);
	Route::get('selections/{id}/edit',['as'=>'selections.edit','uses'=>'SelectionController@edit','middleware' => ['permission:selection-edit']]);
	Route::patch('selections/{id}',['as'=>'selections.update','uses'=>'SelectionController@update','middleware' => ['permission:selection-edit']]);
	
	//criterias - tidak ada permission
	Route::get('criterias',['as'=>'criterias.index','uses'=>'CriteriaController@index']);
	Route::get('criterias/create',['as'=>'criterias.create','uses'=>'CriteriaController@create']);
	Route::post('criterias/create',['as'=>'criterias.store','uses'=>'CriteriaController@store']);
	Route::get('criterias/{id}',['as'=>'criterias.show','uses'=>'CriteriaController@show']);
	Route::get('criterias/{id}/edit',['as'=>'criterias.edit','uses'=>'CriteriaController@edit']);
	Route::patch('criterias/{id}',['as'=>'criterias.update','uses'=>'CriteriaController@update']);
	Route::delete('criterias/{id}',['as'=>'criterias.destroy','uses'=>'CriteriaController@destroy']);

	//preferences - tidak ada permission
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
	
	//auth_role - tidak ada permission
	Route::get('authrole',['as'=>'authrole.index','uses'=>'AuthRoleController@index']);
	Route::post('authrole',['as'=>'authrole.store','uses'=>'AuthRoleController@store']);

	//criteriagroup - ada permission
	Route::get('criteriagroup',['as'=>'criteriagroup.index','uses'=>'CriteriaGroupController@index','middleware' => ['permission:criteriagroup-list|criteriagroup-create|criteriagroup-edit|criteriagroup-delete|criteriagroup-add|criteriagroup-out']]);
	Route::get('criteriagroup/create',['as'=>'criteriagroup.create','uses'=>'CriteriaGroupController@create','middleware' => ['permission:criteriagroup-create']]);
	Route::post('criteriagroup/create',['as'=>'criteriagroup.store','uses'=>'CriteriaGroupController@store','middleware' => ['permission:criteriagroup-create']]);
	Route::get('criteriagroup/{id}/edit',['as'=>'criteriagroup.edit','uses'=>'CriteriaGroupController@edit','middleware' => ['permission:criteriagroup-edit']]);
	Route::patch('criteriagroup/{id}/edit',['as'=>'criteriagroup.update','uses'=>'CriteriaGroupController@update','middleware' => ['permission:criteriagroup-edit']]);
	Route::delete('criteriagroup/{id}',['as'=>'criteriagroup.destroy','uses'=>'CriteriaGroupController@destroy','middleware' => ['permission:criteriagroup-delete']]);
	Route::post('criteriagroup/add',['as'=>'criteriagroup.add','uses'=>'CriteriaGroupController@add','middleware' => ['permission:criteriagroup-add']]);
	Route::post('criteriagroup/out',['as'=>'criteriagroup.out','uses'=>'CriteriaGroupController@out','middleware' => ['permission:criteriagroup-out']]);

	//weight - tidak ada permission
	Route::get('weights',['as'=>'weights.index','uses'=>'WeightController@index']);
	Route::get('weights/{id}/pairwise',['as'=>'weights.pairwise','uses'=>'WeightController@create']);
	Route::patch('weights/{id}',['as'=>'weights.store','uses'=>'WeightController@store']);

	//result_selection - tidak ada permission
	Route::get('result_selection',['as'=>'result_selection.index','uses'=>'ResultSelectionController@index']);
	Route::get('result_selection/{id}/assessment',['as'=>'result_selection.assessment','uses'=>'ResultSelectionController@assessment']);
	Route::patch('result_selection/{id}',['as'=>'result_selection.store','uses'=>'ResultSelectionController@store']);
	Route::post('result_selection/count',['as'=>'result_selection.count','uses'=>'ResultSelectionController@count']);

	//result - tidak ada permission
	Route::get('result',['as'=>'result.index','uses'=>'ResultController@index']);
});
