<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionIdTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE SEQUENCE IF NOT EXISTS public.trx_id_sequence OWNED BY transactions.trx_id;

            CREATE OR REPLACE FUNCTION next_transaction_id() RETURNS TRIGGER AS $$
            DECLARE
                our_epoch       BIGINT := 1314220021721;
                seq_id          BIGINT;
                now_millis      BIGINT;
                shard_id        INT := 5;
                result          BIGINT;
            BEGIN
                SELECT nextval('public.trx_id_sequence') % 1024 INTO seq_id;
                SELECT FLOOR(EXTRACT(EPOCH FROM clock_timestamp()) * 1000) INTO now_millis;
                result          := (now_millis - our_epoch) << 23;
                result          := result | (shard_id << 10);
                result          := result | (seq_id);
                NEW.trx_id      := result;

                RETURN NEW;
            END;
            $$ LANGUAGE 'plpgsql';
        ");

        DB::unprepared("
                CREATE TRIGGER transaction_trx_id BEFORE INSERT ON transactions 
                FOR EACH ROW EXECUTE PROCEDURE next_transaction_id();
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP SEQUENCE public.trx_id_sequence");
        DB::unprepared("DROP TRIGGER IF EXISTS transaction_trx_id ON transactions");
    }
}
