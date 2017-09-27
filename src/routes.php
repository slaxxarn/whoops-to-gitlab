<?php

Route::post('/whoops-to-gitlab/postWhoops', function (\Illuminate\Http\Request $request) {
   $data = [
      'data' => $request->get('_data'),
      'title' => $request->get('auto_title') . ' | ' . $request->get('title')
   ];
   $desc = $request->get('description');

   if (config('gitlab.selected_bin') !== NULL) {
      $bin = new \Dalnix\WhoopsToGitlab\Postbin();
      $pastelink = $bin->sendDataToBin($data);
      $desc = $desc . '\n\nLink to pastebin: <a href="' . $pastelink . '">' . $pastelink . '</a>';
   }

   $gitlab_response = \Dalnix\WhoopsToGitlab\Facades\Gitlab::addIssue(['title' => $data['title'], 'description' => $desc, 'labels' => 'autogenerated']);
   return view('whoopsToGitlab::response')->with('response', $gitlab_response);

})->name('whoopsToGitlab.post');

Route::get('/500', function () {
   Route::all();

});
