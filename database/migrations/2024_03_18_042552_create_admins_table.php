<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('role')->nullable()->comment("1:Super Admin, 2:Admin, 3:Order Admin, 4:Data Entry, 5:Grossory Department Head, 6:Medical Department Head, 7:Marketing, 8:Operations Management, 9:Accounting and Finance, 10:Research and Development (R&D), 11:Production Head")->default("2")->unsigned();
            $table->string('name')->comment("Admin first name Details");
            $table->string('lname', 100)->comment("Admin last name Details");
            $table->string('username', 100)->comment("Admin Username Details");
            $table->unsignedBigInteger('phone')->comment("Admin Contact Details")->unsigned();
            $table->string('bank_name',100)->comment("Admin bank name Details")->nullable();
            $table->string('ifsc_code',100)->comment("Admin ifsc code Details")->nullable();
            $table->string('gender', 12)->nullable()->comment("1=Male, 2=Female, 3=Other");
            $table->string('fax', 100)->comment("Admin Fax Details")->nullable();
            $table->text('aadhar_card')->comment("Admin Aadhar Card Details")->nullable();
            $table->text('id_proof')->comment("Admin Id Proof Details")->nullable();
            $table->text('addressproof')->comment("Admin Address Proof Details")->nullable();
            $table->text('area_location')->comment("Admin area location Details")->nullable();
            $table->string('landmark',255)->comment("Admin landmark Details")->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('pincode')->unsigned()->nullable();
            $table->tinyInteger('region_id')->nullable()->comment("Admin logged in which area location")->unsigned();
            $table->tinyInteger('zone_id')->nullable()->comment("Admin logged in which City/State")->unsigned();
            $table->string('city', 50)->comment("Admin City Name")->nullable();
            $table->string('state', 50)->comment("Admin State Name")->nullable();
            $table->string('country', 50)->comment("Admin Country Name")->nullable();
            $table->dateTime('dob')->nullable()->comment("Date of Birth");
            $table->dateTime('doj')->nullable()->comment("Date of Joining");
            $table->dateTime('dol')->nullable()->comment("Date of leavit");
            $table->dateTime('dolv')->nullable()->comment("Date of leaving");
            $table->string('department_name',100)->nullable()->comment("To which department within the company does the employee belong")->default("Admin Department");
            $table->tinyInteger('status')->comment("1:Active, 2:Deactive, 3:Pending, 4:Rejected")->default("3")->unsigned();
            $table->tinyInteger('employee_experience_level')->comment("1:Intern Employee, 2:Junior Employee, 3:Senior Employee")->default("1")->unsigned();
            $table->unsignedTinyInteger('reporting_manager')->comment("1:Super Admin, 2:Admin, 3:Order Admin, 4:Data Entry, 5:Grossory Department Head, 6:Medical Department Head, 7:Marketing, 8:Operations Management, 9:Accounting and Finance, 10:Research and Development (R&D), 11:Production Head")->default("2");
            $table->unsignedBigInteger('reporting_manager_admin_id')->nullable();
            $table->string('ip_address',50)->comment("Admin System IP Address")->nullable();
            $table->string('countryName')->comment("Admin country Name")->nullable();
            $table->string('countryCode')->comment("Admin country Code")->nullable();
            $table->string('regionCode')->comment("Admin region Code")->nullable();
            $table->string('regionName')->comment("Admin region Name")->nullable();
            $table->string('cityName')->comment("Admin city Name")->nullable();
            $table->float('latitude', 8, 4)->comment("Admin latitude")->nullable();
            $table->float('longitude', 8, 4)->comment("Admin longitude")->nullable();
            $table->string('timezone')->comment("Admin timezone")->nullable();
            $table->timestamp('block_time')->nullable();
            $table->unsignedInteger('login_mode')->comment("1:Admin logged by using System, 2:Admin logged by using Mobile")->unsigned()->default('1');
            $table->unsignedInteger('last_login_mode')->comment("1:Admin logged by using System, 2:Admin logged by using Mobile")->unsigned()->default('1');
            $table->unsignedInteger('last_login_from')->comment("1:Inside Organization, 2:Outside of the Organization")->unsigned()->default('1');
            $table->datetime('last_login_at')->nullable();
            $table->datetime('last_login_time')->commit("last time Admin login")->nullable();
            $table->unsignedInteger('login_count')->comment("1:Admin logged in successfully in first time, 2:If admin is attemped multiple time wrong password or email than admin block 30 minutes")->unsigned()->default('1');
            $table->unsignedInteger('is_currently_logged_in')->comment("1:Admin is currently logged in, 2:Admin is currently logout")->unsigned()->default('2');
            $table->tinyInteger('login_status')->nullable()->comment("1:Login, 2:Logout")->default("2")->unsigned();
            $table->integer('currently_login_admin_count')->unsigned()->nullable();
            $table->string('last_login_ip')->comment("Admin system last login ip address")->nullable();
            $table->string('email')->comment("Admin Email Address")->unique();
            $table->tinyInteger('should_email_verify')->comment("1:When super admin create an admin account that time send mail into admin personal email, and admin is verify email address, 2:When super admin create an admin account that time send mail into admin personal email, but admin is not verify till now")->default("2")->unsigned();
            $table->timestamp('email_verified_at')->comment("Whenever admin verified it's own account that time")->nullable();
            $table->tinyInteger('master_password')->comment("1:when super admin is create an new admin than reset default password, 2:when super admin is create an new admin but default password is not reset by admin")->default("2")->unsigned();
            $table->timestamp('password_modified_at')->nullable();
            $table->string('old_password_1')->comment("Admin first time change password")->nullable();
            $table->string('old_password_2')->comment("Admin second time change password")->nullable();
            $table->string('old_password_3')->comment("Admin third time change password")->nullable();
            $table->string('password')->commet("Whenever admin verified it's own account than after he will set the password");
            $table->string('default_password')->commet("Default Password");
            $table->string('password_verification')->commet("Default Password")->nullable();
            $table->text("access_token")->comment("Admin access token")->unique()->nullable();
            $table->text("api_token")->comment("Admin api token")->unique()->nullable();
            $table->rememberToken();
            $table->string('created_by')->comment("1 : Abhishek Kumar, 2 : Vishal, 3 : Prashant, 4 : Gauri")->default("1");
            $table->string('updated_by')->comment("Admin account updated by")->nullable();
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
