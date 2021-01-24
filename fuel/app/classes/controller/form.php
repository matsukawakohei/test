<?php

class Controller_Form extends Controller_Public
{
  public function action_index()
  {
    $form = $this->forge_form();

    if (Input::method() === 'POST') {
      $form->repopulate();
    }

    $this->template->title = 'コンタクトフォーム';
    $this->template->content = View::forge('form/index');
    $this->template->content->set_safe('html_form', $form->build('form/confirm'));
  }

  public function forge_validation()
  {
    $val = Validation::forge();

    $val->add('name', '名前')
        ->add_rule('trim')
        ->add_rule('required')
        ->add_rule('no_tab_and_newline')
        ->add_rule('max_length', 50);

    $val->add('email', 'メールアドレス')
        ->add_rule('trim')
        ->add_rule('required')
        ->add_rule('no_tab_and_newline')
        ->add_rule('valid_email');

    $val->add('comment', 'コメント')
        ->add_rule('required')
        ->add_rule('max_length', 400);

    return $val;
  }

  public function action_confirm()
  {
    $form = $this->forge_form();
    $val = $form->validation()->add_callable('MyValidationRules');

    if ($val->run()) {
      $data['input'] = $val->validated();
      $this->template->title = 'コンタクトフォーム：確認';
      $this->template->content = View::forge('form/confirm', $data);
    } else {
      $form->repopulate();
      $this->template->title = 'コンタクトフォーム：エラー';
      $this->template->content = View::forge('form/index');
      $this->template->content->set_safe('html_error', $val->show_errors());
      $this->template->content->set_safe('html_form', $form->build('form/confirm'));
    }
  }

  public function action_send()
  {
    if (!Security::check_token()) {
      throw new HttpInvalidInputException('ページ遷移が正しくありません');
    }

    $form = $this->forge_form();
    $val = $form->validation()->add_callable('MyValidationRules');

    if (!$val->run()) {
      $form->repopulate();
      $this->template->title = 'コンタクトフォーム: エラー';
      $this->template->content = View::forge('form/index');
      $this->template->contetn->set_safe('html_error', $val->show_errors());
      $this->template->content->set_safe('html_form', $form->build('form/confirm'));
      return;
    }

    $post = $val->validated();

    try {
      $mail = new Model_Mail();
      $mail->send($post);
      $this->template->title = 'コンタクトフォーム: 送信完了';
      $this->template->content = View::forge('form/send');

      return;
    } catch (EmailValidationFailedException $e) {
      Log::error('メール検証エラー:' .$e->getMessage(), __METHOD__);
      $html_error = '<p>メールアドレスに誤りがあります。</p>';
    } catch (EmailSendingFailedException $e) {
      Log::error('メール送信エラー:' .$e->getMessage(), __METHOD__);
      $html_error = '<p>メールを送信できませんでした。</p>';
    }

    $form->repopulate();
    $this->template->title = 'コンタクトフォーム: 送信エラー';
    $this->template->content = View::forge('form/index');
    $this->template->content->set_safe('html_error', $html_error);
    $this->template->content->set_safe('html_form', $form->build('form/confirm'));
  }

  public function forge_form()
  {
    $form = Fieldset::forge();

    $form->add('name', '名前')
        ->add_rule('trim')
        ->add_rule('required')
        ->add_rule('no_tab_and_newline')
        ->add_rule('max_length', 50);

    $form->add('email', ' メールアドレス')
        ->add_rule('trim')
        ->add_rule('required')
        ->add_rule('no_tab_and_newline')
        ->add_rule('max_length', 50)
        ->add_rule('valid_email');

    $form->add('comment', 'コメント', ['type' => 'textarea', 'cols' => 70, 'rows' => 6])
        ->add_rule('required')
        ->add_rule('max_length', 400);


    $form->add('submit', '', ['type' => 'submit', 'value' => '確認']);

    return $form;
  }
}
