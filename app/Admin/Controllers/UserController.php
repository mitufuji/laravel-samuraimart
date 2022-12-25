<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('email_verified_at', __('Email verified at'));
        $grid->column('postal_code', __('Postal code'));
        $grid->column('address', __('Address'));
        $grid->column('phone', __('Phone'));
        $grid->column('delete_flag', __('Delete flag'));
        $grid->column('create_at', __('Create_at'))->sortable();
        $grid->column('update_at', __('Update_at'))->sortable();

        $grid->filter(function($filter) {
            $filter->like('name','ユーザー名');
            $filter->like('email','メールアドレス');
            $filter->like('postal_code','郵便番号');
            $filter->like('address','住所');
            $filter->like('phone','電話番号');
            $filter->equal('delete_flag','論理削除')
                   ->select(['0' => 'false', '1'=> 'ture']);
            $filter->between('namecreate_at','登録日')->datetime();
        });


        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));        
        $show->field('postal_code', __('Postal code'));
        $show->field('address', __('Address'));
        $show->field('phone', __('Phone'));
        $show->field('delete_flag', __('Delete flag'));
        $show->field('create_at', __('Create_at'));
        $show->field('update_at', __('Update_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->datetime('email_verified_at', __('Email verified at'))
             ->default(date('Y-m-d H:i:s'));
        $form->password('password', __('Password'));        
        $form->text('postal_code', __('Postal code'));
        $form->textarea('address', __('Address'));
        $form->mobile('phone', __('Phone'));
        $form->switch('delete_flag', __('Delete flag'));

        $form->saving(function(Form $form){
            if($form->password && $form->model()->password != $form->password) {
                $form->password = bcrypt($form->password);
            } else {
                $form->password = $form->model()->password;
            }
        });

        return $form;
    }
}
