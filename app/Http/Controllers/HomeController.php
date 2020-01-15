<?php

namespace App\Http\Controllers;

use App\Task;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->middleware('auth');
        $this->task = $task;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $isert = DB::select("INSERT INTO `cidade` (`id`, `cidade`) VALUES ('29', 'Salvador')"); //inserções na banco

        $cidades = DB::select('select * from cidade'); //get no banco todas inf
        //dd($cidades);
        $busca = 23; // recebe o codigo que vai buscar

        //varre o array buscando o reultado
        foreach ($cidades as $cidade) {

            if ($cidade->id == $busca) {
                //retorna abusca
                return $cidade->cidade;
                exit;
            }
        }
        //se não encontrar nada retorna falso
        return false;
        //dd($cidade);

        //dd($cidades);
        return view('home');
    }

    public function imc(Request $request)
    {
        //trato as informações nas variaveis
        $nome = $request->nome;
        $made = $request->made;
        $altura = $request->altura;
        $peso = $request->peso;
        //calcula o imc
        $imc = $peso / $altura;

        //if de resultados
        if ($imc < 16) {
            $resultado = "Subpeso Severo";
        } else if ($imc >= 16 || $imc < 19.9) {
            $resultado = "Subpeso";
        } else if ($imc >= 20 || $imc < 24.9) {
            $resultado = "Normal";
        } else if ($imc >= 25 || $imc < 29.9) {
            $resultado = "Sobrepeso";
        } else if ($imc >= 30 || $imc < 39.9) {
            $resultado = "Obeso";
        } else if ($imc >= 40) {
            $resultado = "Obeso Mórbido";
        }

        //dd($imc);
        //retorna o resultado
        $sql = DB::select('INSERT INTO `imc` (`nome`,`altura`,`peso`,`made`) VALUES (' . $nome . ', ' . $altura . ', ' . $peso . ', ' . $made . ')');
        echo $resultado;
        exit;

        echo $resultado;
        exit;

    }
}
