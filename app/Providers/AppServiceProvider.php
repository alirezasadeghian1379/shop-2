<?php

namespace App\Providers;

use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Repositories\Admin\{AdminModuleRepository, IAdminRepository, Models\Admin};
use App\Repositories\Question\{IQuestionRepository,QuestionModuleRepository};
use App\Repositories\Slider\{ISliderRepository,SliderModuleRepository};
use App\Repositories\User\{IUserRepository,UserModuleRepository};
use App\Repositories\State\Contracts\{ICityRepository,IProvinceRepository};
use App\Repositories\State\Repositories\{CityModuleRepository,ProvinceModuleRepository};
use App\Services\SettingService;
use App\Repositories\Role\{IRoleRepository, Models\Role, RoleModuleRepository};
use App\Repositories\Setting\{ISettingRepository,SettingModuleRepository};
use App\Repositories\AuthAdmin\{AuthAdminModuleRepository,IAuthAdminRepository};
use App\Repositories\Gallery\Contracts\{IGalleryDbRepository,IGalleryStorageRepository};
use App\Repositories\Gallery\Repositories\{GalleryDbModuleRepository,GalleryStorageModuleRepository};
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use function PHPUnit\Framework\isString;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IAuthAdminRepository::class,AuthAdminModuleRepository::class);
        $this->app->bind(IGalleryDbRepository::class,GalleryDbModuleRepository::class);
        $this->app->bind(IGalleryStorageRepository::class,GalleryStorageModuleRepository::class);
        $this->app->bind(ISettingRepository::class,SettingModuleRepository::class);
        $this->app->bind(IAdminRepository::class,AdminModuleRepository::class);
        $this->app->bind(IRoleRepository::class,RoleModuleRepository::class);
        $this->app->bind(IProvinceRepository::class,ProvinceModuleRepository::class);
        $this->app->bind(ICityRepository::class,CityModuleRepository::class);
        $this->app->bind(IUserRepository::class,UserModuleRepository::class);
        $this->app->bind(IQuestionRepository::class,QuestionModuleRepository::class);
        $this->app->bind(ISliderRepository::class,SliderModuleRepository::class);

        $this->app->singleton('logo', function ($app) {
            $settingService = $app->make(SettingService::class);
            $logoSetting = $settingService->findByKey('logo');
            $logoSettingPath = $logoSetting?->logo?->path;
            return empty($logoSettingPath) ? null : asset('storage/'.$logoSettingPath);
        });
        $this->app->singleton('icon', function ($app) {
            $settingService = $app->make(SettingService::class);
            $iconSetting = $settingService->findByKey('icon');
            $iconSettingPath = $iconSetting?->icon?->path;
            return empty($iconSettingPath) ? null : asset('storage/'.$iconSettingPath);
        });
        $this->app->singleton('siteName', function ($app) {
            $settingService = $app->make(SettingService::class);
            $titleSiteSetting = $settingService->findByKey('titleSite');
            $titleSiteSettingValue = $titleSiteSetting?->value;
            return empty($titleSiteSettingValue) ? null : $titleSiteSettingValue;
        });
        $this->app->singleton('permissions', function ($app) {
            return auth()->user()->getAllPermissions()->pluck('name')->toArray();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        Gate::policy(Admin::class,UserPolicy::class);
        Gate::policy(Role::class,RolePolicy::class);

        Response::macro('success', function ($data, $message = null , $code = 200,$data2 = null) {
            if (isset($data2)){
                return response()->json([
                    'status' => 'success',
                    'message' => $message,
                    'data' => $data,
                    'data2' => $data2,
                ], $code);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => $message,
                    'data' => $data,
                ], $code);
            }
        });
        Response::macro('error', function ($e, $message = 'error', $code = 500) {
            if ($code == 500){
                return response()->json([
                    'status' => 'error',
                    'data' => [
                        'message' => $e->getMessage() ,
                        'file' => $e->getFile() ,
                        'line' => $e->getLine()
                    ]
                ], $code);
            } else {
                return response()->json([
                    'status' => 'error',
                    'data' => [
                        'message' => isString($e) ? $message : $e->getMessage(),
                    ]
                ], $code);
            }

        });
        Response::macro('paginate',function($paginator,$data,$message = 'اطلاعات با موفقیت دریافت شد', $code = 200){
            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $data,
                'meta' => [
                    'per_page' => $paginator->perPage,
                    'total' => $paginator->total,
                    'current_page' => $paginator->currentPage,
                    'last_page' => $paginator->lastPage,
                    'pages' => [10, 20, 30, 40]]
            ], $code);
        });
    }
}
