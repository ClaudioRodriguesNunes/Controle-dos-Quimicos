# Projeto Controle de Produtos Químicos (PGP-1)

Este é um projeto acadêmico em dupla para a disciplina de Banco de Dados e Desenvolvimento Web, cujo objetivo é controlar produtos químicos na plataforma Garoupa (PGP-1) da Petrobras.

## 📖 Funcionalidades

O sistema oferece CRUD completo para as seguintes entidades:

- **Produtos Químicos** (`ProdutoQuimico`): nome, validade  
- **Pessoas** (`Pessoa`): cadastro geral  
- **Supervisores de Produção** (`SupervisorProducao`): vincula `Pessoa` como supervisor  
- **Operadores de Produção** (`OperadorProducao`): vincula `Pessoa` como operador  
- **Recipientes** (`Recipiente`): bombonas, barris, tanques portáteis  
- **Tanques Operacionais** (`TanqueOperacional`): status, localização, capacidade, nível atual  
- **Movimentações de Estoque** (`MovimentacaoEstoque`): abastecimento/retorno de recipientes  
- **Solicitações GEM** (`SolicitaGEM`): requisições de entrada e saída de produtos  

O minimundo e o DDL estão em `estrutura.sql`; o documento de especificação detalha regras de negócio.

## 🚀 Tecnologias

- **Web server:** WampServer (Apache + MySQL/MariaDB)  - link para acessar os controles: http://localhost/controle_quimicos/controles_php/
- **Back-end:** PHP 8+ (PDO)  
- **Banco de Dados:** MySQL (ou MariaDB)  
- **Front-end:** HTML5, CSS3, Bootstrap 5 (via CDN ou scripts_css/)  
- **Documentação:** PHPDoc (phpDocumentor)  

## 🗂️ Estrutura de Pastas

```text
controle_quimicos/
├ config/
│   └ database.php              ← configuração de conexão PDO
├ controles_php/               ← controllers
│   ├ ProdutoController.php
│   ├ PessoaController.php
│   ├ SupervisorController.php
│   ├ OperadorController.php
│   ├ RecipienteController.php
│   ├ TanqueOperacionalController.php
│   ├ MovimentacaoEstoqueController.php
│   └ SolicitaGEMController.php
├ classe_dados/                ← models CRUD
│   ├ ProdutoDado.php
│   ├ PessoaDado.php
│   ├ SupervisorDado.php
│   ├ OperadorDado.php
│   ├ RecipienteDado.php
│   ├ TanqueOperacionalDado.php
│   ├ MovimentacaoEstoqueDado.php
│   └ SolicitaGEMDado.php
├ templates_html/              ← views Bootstrap
│   ├ produto_list.php
│   ├ produto_form.php
│   ├ pessoa_list.php
│   ├ pessoa_form.php
│   ├ supervisor_list.php
│   ├ supervisor_form.php
│   ├ operador_list.php
│   ├ operador_form.php
│   ├ recipiente_list.php
│   ├ recipiente_form.php
│   ├ tanque_operacional_list.php
│   ├ tanque_operacional_form.php
│   ├ movimentacao_estoque_list.php
│   ├ movimentacao_estoque_form.php
│   └ solicita_gem_list.php
│   └ solicita_gem_form.php
├ BD
|   └ estrutura.sql
├ scripts_css/                 ← CSS customizado ou Bootstrap local
├ testar_conexao.php           ← script simples para validar PDO
└ estrutura.sql                ← DDL do banco de dados
