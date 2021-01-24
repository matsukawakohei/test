<?php

use Fuel\Core\Controller;

class Controller_ShowFile extends Controller
{
  public function action_index()
  {
    // ファイル名を指定
    $file = DOCROOT . 'show_file.php';

    // ファイルの中身を代入
    $content = file_get_contents($file);

    // Viewオブジェクトを生成
    $view = View::forge('ShowFile');

    // Viewにtitleをセット
    $view->set('title', 'ファイル表示プログラム');

    // ViewにContentsをセット
    $view->set('content', $content);

    return $view;

  }
}