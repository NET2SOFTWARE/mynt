<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVwMyntView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('create or replace view vw_mynt AS
        select a.id as id,h.number as account_number, h.mynt_id as id_mynt,a.name as name, a.email as email, a.phone as phone, 
        a.password_otp as password_otp, a.password as password,a.created_at as created_at, a.updated_at as updated_at, 
        a.deleted_at as deleted_at, i.name as name_account_types
        from users a
        left join user_members b on a.id=b.user_id --member_id
        left join user_companies c on a.id=c.user_id --company_id
        left join user_merchants d on a.id=d.user_id --merchant_id
        left join member_accounts e on b.member_id=e.member_id
        left join company_accounts f on c.company_id=f.company_id
        left join merchant_accounts g on d.merchant_id=g.merchant_id
        left join accounts h on (h.id = e.account_id OR h.id=f.account_id OR h.id=g.account_id)
        left join account_types i on h.account_type_id=i.id');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop view if exists vw_mynt cascade');
    }
}
