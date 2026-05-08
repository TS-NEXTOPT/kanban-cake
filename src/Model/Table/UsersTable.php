<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        $this->hasMany('Projects', ['foreignKey' => 'created_by']);
        $this->belongsToMany('Memberships', [
            'className' => 'Projects',
            'through' => 'ProjectMembers',
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'project_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        return $validator
            ->email('email')->notEmptyString('email', 'メールアドレスを入力してください')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => '既に登録されているメールアドレスです'])
            ->scalar('password')->minLength('password', 8, 'パスワードは8文字以上にしてください')->notEmptyString('password', 'パスワードを入力してください')
            ->scalar('name')->maxLength('name', 100)->notEmptyString('name', '名前を入力してください');
    }

    public function buildRules(\Cake\ORM\RulesChecker $rules): \Cake\ORM\RulesChecker
    {
        $rules->add($rules->isUnique(['email'], 'このメールアドレスは既に使われています'));
        return $rules;
    }
}
