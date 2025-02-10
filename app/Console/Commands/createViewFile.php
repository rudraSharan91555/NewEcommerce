<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;


class createViewFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:adminTableview {view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new view file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $viewname = $this->argument('view');

        $viewname = $viewname . '.blade.php';

        $pathname = "resources/views/{$viewname}";

        if (File::exists($pathname)) {
            $this->error("file {$pathname} is already exist ");
            return;
        }
        $dir = dirname($pathname);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $content = '@extends("admin/layout")
        @section("content")
        <div class="page-wrapper">
            <div class="page-content">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">ADD NAME</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">ADD NAME</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="ms-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary">Settings</button>
                            <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item" href="javascript:;">Action</a>
                                <a class="dropdown-item" href="javascript:;">Another action</a>
                                <a class="dropdown-item" href="javascript:;">Something else here</a>
                                <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h6 class="mb-0 text-uppercase">ADD NAME</h6>
                        <hr/>
                        <div class="col">
                                                <button type="button" class="btn btn-outline-info px-5 radius-30">Add ADD NAME</button>
                                            </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example2" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Text</th>
                                                <th>Link</th>
                                                <th>Image</th>
                                                <th>Created_at</th>
                                                <th>Updated_at</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $list)
                                            <tr>
                                                <td>1</td>
                                                <td>Text</td>
                                                <td>Link</td>
                                                <td>Image</td>
                                                <td>12-12-29</td>
                                                <td>12-12-29</td>
        
                                            
                                                
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                            <th>Id</th>
                                                <th>Text</th>
                                                <th>Link</th>
                                                <th>Image</th>
                                                <th>Created_at</th>
                                                <th>Updated_at</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
            </div>
        
        </div>
        @endsection';

        File::put($pathname, $content);

        $this->info("File {$pathname} is created");
    }
}