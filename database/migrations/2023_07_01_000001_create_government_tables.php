<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Departments
        Schema::create('government_departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('head_name')->nullable();
            $table->string('head_title')->nullable();
            $table->string('head_image')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->default('active');
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // Department Staff
        Schema::create('government_department_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('government_departments')->onDelete('cascade');
            $table->string('name');
            $table->string('position');
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // Department Functions
        Schema::create('government_department_functions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('government_departments')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Services
        Schema::create('government_services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->text('description');
            $table->string('icon')->nullable();
            $table->string('featured_image')->nullable();
            $table->foreignId('department_id')->nullable()->constrained('government_departments')->nullOnDelete();
            $table->string('status')->default('active');
            $table->boolean('is_featured')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // Service Procedures
        Schema::create('government_service_procedures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('government_services')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->integer('step_number');
            $table->timestamps();
        });

        // Service Required Documents
        Schema::create('government_service_required_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('government_services')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_required')->default(true);
            $table->timestamps();
        });

        // Service FAQs
        Schema::create('government_service_faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('government_services')->onDelete('cascade');
            $table->string('question');
            $table->text('answer');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Project Categories
        Schema::create('government_project_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        // Projects
        Schema::create('government_projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('government_project_categories')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('government_departments')->nullOnDelete();
            $table->string('location')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('budget', 15, 2)->nullable();
            $table->string('status')->default('ongoing');
            $table->string('featured_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('completion_percentage')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // Project Updates
        Schema::create('government_project_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('government_projects')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->date('update_date');
            $table->integer('completion_percentage')->nullable();
            $table->timestamps();
        });

        // Project Images
        Schema::create('government_project_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('government_projects')->onDelete('cascade');
            $table->string('image');
            $table->string('caption')->nullable();
            $table->date('capture_date')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // News Categories
        Schema::create('government_news_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        // News Tags
        Schema::create('government_news_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // News
        Schema::create('government_news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('government_news_categories')->nullOnDelete();
            $table->dateTime('published_at')->nullable();
            $table->string('status')->default('draft');
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('views')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        // News-Tag Pivot
        Schema::create('government_news_tag', function (Blueprint $table) {
            $table->foreignId('news_id')->constrained('government_news')->onDelete('cascade');
            $table->foreignId('tag_id')->constrained('government_news_tags')->onDelete('cascade');
            $table->primary(['news_id', 'tag_id']);
        });

        // Announcements
        Schema::create('government_announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->boolean('is_urgent')->default(false);
            $table->dateTime('publish_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        // Testimonials
        Schema::create('government_testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->text('content');
            $table->string('avatar')->nullable();
            $table->integer('rating')->default(5);
            $table->string('status')->default('active');
            $table->foreignId('service_id')->nullable()->constrained('government_services')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // Statistics
        Schema::create('government_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->integer('value');
            $table->string('label');
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('government_statistics');
        Schema::dropIfExists('government_testimonials');
        Schema::dropIfExists('government_announcements');
        Schema::dropIfExists('government_news_tag');
        Schema::dropIfExists('government_news');
        Schema::dropIfExists('government_news_tags');
        Schema::dropIfExists('government_news_categories');
        Schema::dropIfExists('government_project_images');
        Schema::dropIfExists('government_project_updates');
        Schema::dropIfExists('government_projects');
        Schema::dropIfExists('government_project_categories');
        Schema::dropIfExists('government_service_faqs');
        Schema::dropIfExists('government_service_required_documents');
        Schema::dropIfExists('government_service_procedures');
        Schema::dropIfExists('government_services');
        Schema::dropIfExists('government_department_functions');
        Schema::dropIfExists('government_department_staff');
        Schema::dropIfExists('government_departments');
    }
};