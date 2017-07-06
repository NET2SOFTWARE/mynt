<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateAccountNumberTriggering extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
                CREATE OR REPLACE FUNCTION account_number_generator() RETURNS TRIGGER AS $$
                DECLARE
                    no_acc              VARCHAR(12);
                    last_no_acc         VARCHAR(12);
                    no_acc_cast         BIGINT;
                BEGIN
                    SELECT number FROM accounts WHERE number LIKE CONCAT(NEW.number, '%') ORDER BY created_at DESC LIMIT 1
                    INTO last_no_acc;
                    
                    IF NOT FOUND THEN
                        NEW.number          := CONCAT(NEW.number, '0000000');
                    ELSE
                        no_acc_cast     := CAST(SUBSTR(last_no_acc, 4, 9) AS BIGINT);
                        no_acc_cast     := no_acc_cast + 1;
                        no_acc          := SUBSTR(CAST(no_acc_cast AS VARCHAR), 1);
                        NEW.number      := CONCAT(NEW.number, SUBSTR(no_acc, 3));
                    END IF;
                    
                RETURN NEW;
                END;  
                  
                $$  
                LANGUAGE 'plpgsql';;
        ");

        DB::unprepared("
                CREATE TRIGGER account_number BEFORE INSERT ON accounts 
                FOR EACH ROW EXECUTE PROCEDURE account_number_generator();
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS account_number ON accounts");
    }
}
