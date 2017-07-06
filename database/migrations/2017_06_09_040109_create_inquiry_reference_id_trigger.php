<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateInquiryReferenceIdTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE SEQUENCE IF NOT EXISTS public.reference_id_sequence OWNED BY inquiries.reference_id;

            CREATE OR REPLACE FUNCTION next_reference_id() RETURNS TRIGGER AS $$
            DECLARE
                our_epoch       BIGINT := 1314220021721;
                seq_id          BIGINT;
                now_millis      BIGINT;
                shard_id        INT := 5;
                result          BIGINT;
            BEGIN
                SELECT nextval('public.reference_id_sequence') % 1024 INTO seq_id;
                SELECT FLOOR(EXTRACT(EPOCH FROM clock_timestamp()) * 1000) INTO now_millis;
                result          := (now_millis - our_epoch) << 23;
                result          := result | (shard_id << 10);
                result          := result | (seq_id);
                NEW.reference_id      := result;

                RETURN NEW;
            END;
            $$ LANGUAGE 'plpgsql';
        ");

        DB::unprepared("
                CREATE TRIGGER inquiries_reference_id BEFORE INSERT ON inquiries 
                FOR EACH ROW EXECUTE PROCEDURE next_reference_id();
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP SEQUENCE public.reference_id_sequence");
        DB::unprepared("DROP TRIGGER IF EXISTS inquiries_reference_id ON inquiries");
    }
}
