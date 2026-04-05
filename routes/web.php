<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AfiliacaoController;
use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\PremioAdminController;
use App\Http\Controllers\PremioCreateController;
use App\Http\Controllers\PremioController;
use App\Http\Controllers\MembroAdminController;
use App\Http\Controllers\CadastroSolicitacaoController;
use Illuminate\Support\Facades\Artisan;
/*
|--------------------------------------------------------------------------
| HOME / LANDING
|--------------------------------------------------------------------------
*/

Route::view('/', 'home')->name('home');

/*
|--------------------------------------------------------------------------
| PÁGINAS PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::view('/obrigado', 'public.obrigado')->name('public.obrigado');
Route::view('/politica-de-privacidade', 'public.politica-privacidade')->name('public.politica');

/*
|--------------------------------------------------------------------------
| AFILIAÇÃO
|--------------------------------------------------------------------------
*/

Route::post('/afiliacao', [AfiliacaoController::class, 'store'])
    ->name('afiliacao.store');

/*
|--------------------------------------------------------------------------
| AUTENTICAÇÃO
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    Route::view('/login', 'auth.login')->name('login');

    Route::post('/login', [AuthWebController::class, 'login'])
        ->name('auth.login.post');

    /*
    |--------------------------------------------------------------------------
    | RESET DE SENHA
    |--------------------------------------------------------------------------
    */

    Route::view('/senha/solicitar', 'auth.solicitar-troca-senha')
        ->name('password.request');

    Route::post('/senha/solicitar', [ForgotPasswordController::class, 'send'])
        ->middleware('throttle:5,1')
        ->name('password.email');

    Route::get('/senha/resetar-senha/{token}', [ResetPasswordController::class, 'show'])
        ->name('password.reset');

    Route::post('/senha/resetar-senha', [ResetPasswordController::class, 'update'])
        ->name('password.update');
});

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthWebController::class, 'logout'])
    ->middleware('auth')
    ->name('auth.logout');

/*
|--------------------------------------------------------------------------
| CLUBE (ÁREA PROTEGIDA)
|--------------------------------------------------------------------------
*/

Route::prefix('clube')->middleware('auth')->group(function () {

    Route::get('/pontos-e-premios', [PremioController::class, 'index'])
        ->name('clube.pontos');

    Route::post('/pontos-e-premios/resgatar/{premio}', [PremioController::class, 'resgatar'])
        ->name('premios.resgatar');

    Route::get('/pontos-e-premios/sucesso/{resgate}', [PremioController::class, 'sucesso'])
        ->name('premios.sucesso');
});

/*
|--------------------------------------------------------------------------
| CLUBE ADMIN (APENAS ADMIN)
|--------------------------------------------------------------------------
*/

Route::get('/migrate', function () {
    Artisan::call('migrate', [
        '--force' => true
    ]);

    return 'Migrations executadas!';
});

Route::prefix('clube')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::view('/novos-membros', 'club.novos-membros')
            ->name('clube.novos_membros');

        Route::get('/premios', [PremioAdminController::class, 'index'])
            ->name('premios.index');

        Route::get('/premios/novo', [PremioCreateController::class, 'create'])
            ->name('premios.create');

        Route::post('/premios', [PremioCreateController::class, 'store'])
            ->name('premios.store');

        Route::put('/premios/{premio}', [PremioAdminController::class, 'update'])
            ->name('premios.update');

        Route::delete('/premios/{premio}', [PremioAdminController::class, 'destroy'])
            ->name('premios.destroy');
        
        Route::get('/membros-admin', [MembroAdminController::class, 'index'])
            ->name('membros.admin');
        Route::post('/membros-admin/{user}/movimentar-pontos', [MembroAdminController::class, 'movimentar'])
            ->name('membros.movimentar');

        Route::get('solicitacoes-cadastro', [CadastroSolicitacaoController::class, 'index'])
            ->name('cadastros.solicitacoes.index');

        Route::patch('solicitacoes-cadastro/{id}/aprovar', [CadastroSolicitacaoController::class, 'aprovar'])
            ->name('cadastros.solicitacoes.aprovar');

        Route::delete('solicitacoes-cadastro/{id}/recusar', [CadastroSolicitacaoController::class, 'recusar'])
            ->name('cadastros.solicitacoes.recusar');

        Route::patch('solicitacoes-cadastro/{id}/aprovar-admin', [CadastroSolicitacaoController::class, 'aprovarAdmin'])
            ->name('cadastros.solicitacoes.aprovarAdmin');

    });


    