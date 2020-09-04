@extends('app')

@section('content')
<nav class="navbar navbar-expand-sm bg-primary navbar-primary">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link text-white" href="#" data-toggle="modal" data-target="#modalNovo" onclick="cadastrar()">
        Novo
     </a>
    </li>
  </ul>
</nav>
<br>
<div class="container">
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  @if ( session('message') )
    <div class="alert alert-success" role="alert">
      {{ session('message') }}
    </div>
  @endif
  <h2>Lista de motoristas</h2>
  <div style="overflow-y:scroll;">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Nome</th>
          <th>CPF</th>
          <th>Email</th>
          <th>Situação</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach (\App\Motorista::all() as $motorista)
          <tr>
            <td>{{ $motorista->nome }}</td>
            <td>{{ $motorista->cpf }}</td>
            <td>{{ $motorista->email }}</td>
            <td>{{ $motorista->situacao }}</td>
            <td>{{ $motorista->status }}</td>
            <td>
              <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#modalNovo" onclick="cadastrar('{{ $motorista->toJson() }}')">Atualizar</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#modalDeletar" onclick="motoristaFormDeletar.action = '/motoristas/{{ $motorista->id }}';">Deletar</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="modalNovo">
 <div class="modal-dialog">
   <div class="modal-content">

     <div class="modal-header">
       <h4 class="modal-title" id="tituloModal">Novo</h4>
       <button type="button" class="close" data-dismiss="modal">&times;</button>
     </div>

     <form method="POST" action="/motoristas" name="motoristaForm">
      @csrf
      @method('POST')
      <div class="modal-body">
        <div class="form-group">
          <label for="nome">Nome:</label>
          <input type="text" class="form-control" id="nome" name="nome" maxlength="100">
        </div>
        <div class="form-group">
          <label for="cpf">CPF:</label>
          <input type="text" class="form-control" id="cpf" name="cpf" maxlength="11" placeholder="Somente números">
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="text" class="form-control" id="email" name="email" maxlength="320">
        </div>				  
        <div class="form-group">
          <label for="situacao">Situação:</label>
          <select class="form-control" id="situacao" name="situacao">
            <option>livre</option>
            <option>em curso</option>
            <option>retornando</option>
          </select>
        </div>
        <div class="form-group">
          <label for="status">Status:</label>
          <select class="form-control" id="status" name="status">
            <option>ativo</option>
            <option>inativo</option>
          </select>
        </div>				  
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="motoristaForm.submit()">Confirmar</button>
      </div>
     </form>
   </div>
 </div>
</div>

<div class="modal fade" id="modalDeletar">
  <div class="modal-dialog">
    <div class="modal-content">
 
      <div class="modal-header">
        <h4 class="modal-title">Deletar</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
 
      <form method="POST" action="/motoristas" name="motoristaFormDeletar">
        @csrf
        @method('DELETE')
        <div class="modal-body">
          Confirma a remoção do item clicado?
        </div>
      </form>
 
       <div class="modal-footer">
         <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
         <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="motoristaFormDeletar.submit()">Confirmar</button>
       </div>
      </form>
    </div>
  </div>

  <script>
    var cadastrar = function(motorista){
      if( motorista ) {
        document.getElementById('tituloModal').innerHTML = 'Atualizando motorista';
        motorista = JSON.parse(motorista);
        motoristaForm.action = `/motoristas/${motorista.id}`;
        motoristaForm['_method'].value = "PUT";
        motoristaForm.nome.value     = motorista.nome;
        motoristaForm.cpf.value      = motorista.cpf;
        motoristaForm.email.value    = motorista.email;
        motoristaForm.situacao.value = motorista.situacao;
        motoristaForm.status.value   = motorista.status;
      } else {
        document.getElementById('tituloModal').innerHTML = 'Novo motorista';
        motoristaForm.reset();
        motoristaForm.action = "/motoristas";
        motoristaForm['_method'].value = "POST";
      }

    }
  </script>
 </div>@endsection