<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AfiliacaoController extends Controller
{
    public function store(Request $request)
    {
        $profissoesPermitidas = [
            'Arquiteto',
            'Engenheiro',
            'Corretor de imóveis',
        ];

        $request->merge([
            'email' => mb_strtolower((string) $request->email),
            'telefone' => preg_replace('/\D/', '', (string) $request->telefone),
            'cpf_cnpj' => preg_replace('/\D/', '', (string) $request->cpf_cnpj),
            'rrt' => trim((string) $request->rrt),
        ]);

        $data = $request->validate([
            'nome' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:190', 'unique:users,email'],
            'senha' => ['required', 'string', Password::min(8), 'same:senhaconfirmacao'],
            'senhaconfirmacao' => ['required', 'string'],

            'telefone' => [
                'required',
                'digits_between:10,11',
                'not_regex:/^(\d)\1+$/',
            ],

            'cpf_cnpj' => [
                'required',
                'digits_between:11,14',
                'not_regex:/^(\d)\1+$/',
                'unique:users,cpf_cnpj',
            ],

            'profissao' => [
                'required',
                'string',
                Rule::in($profissoesPermitidas),
            ],

            'rrt' => ['required', 'string', 'max:50'],
            'aceite_termos' => ['accepted'],
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'nome.max' => 'O nome deve ter no máximo 255 caracteres.',

            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.max' => 'O e-mail deve ter no máximo 190 caracteres.',
            'email.unique' => 'Este e-mail já está cadastrado.',

            'senha.required' => 'O campo senha é obrigatório.',
            'senha.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'senha.same' => 'A confirmação de senha não confere.',

            'senhaconfirmacao.required' => 'O campo confirmação de senha é obrigatório.',

            'telefone.required' => 'O campo telefone é obrigatório.',
            'telefone.digits_between' => 'O telefone deve conter entre 10 e 11 números.',
            'telefone.not_regex' => 'Informe um telefone válido.',

            'cpf_cnpj.required' => 'O campo CPF ou CNPJ é obrigatório.',
            'cpf_cnpj.digits_between' => 'O CPF deve conter 11 números ou o CNPJ 14 números.',
            'cpf_cnpj.not_regex' => 'Informe um CPF ou CNPJ válido.',
            'cpf_cnpj.unique' => 'Este CPF ou CNPJ já está cadastrado.',

            'profissao.required' => 'O campo profissão é obrigatório.',
            'profissao.in' => 'A profissão selecionada é inválida.',

            'rrt.required' => 'O campo RRT é obrigatório.',
            'rrt.max' => 'O campo RRT deve ter no máximo 50 caracteres.',

            'aceite_termos.accepted' => 'Você deve aceitar os Termos e Condições e a Política de Privacidade.',
        ]);

        User::create([
            'name' => $data['nome'],
            'email' => $data['email'],
            'password' => Hash::make($data['senha']),
            'telefone' => $data['telefone'],
            'cpf_cnpj' => $data['cpf_cnpj'],
            'profissao' => $data['profissao'],
            'rrt' => $data['rrt'],
            'role' => 'associado',
            'pontos' => 0,
            'aprovado' => 'N',
        ]);

        return redirect()
            ->route('public.obrigado')
            ->with('success', 'Cadastro enviado! Aguarde a confirmação.');
    }
}