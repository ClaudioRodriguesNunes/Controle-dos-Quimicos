# Projeto Controle de Produtos Químicos (PGP-1)

Este é um projeto acadêmico em dupla para a disciplina de Banco de Dados e Desenvolvimento Web, cujo objetivo é controlar produtos químicos na plataforma Garoupa (PGP-1) da Petrobras.

## 📖 Funcionalidades

O sistema oferece CRUD completo para as seguintes entidades:

- **Produtos Químicos** (`ProdutoQuimico`): nome e validade padrão
- **Pessoas** (`Pessoa`): cadastro geral com equipe
- **Supervisores de Produção** (`SupervisorProducao`): extensão da Pessoa
- **Operadores de Produção** (`OperadorProducao`): extensão da Pessoa
- **Recipientes** (`Recipiente`): bombonas, barris, tanques portáteis com datas e capacidade
- **Tanques Operacionais** (`TanqueOperacional`): status, localização, capacidade, nível atual
- **Movimentações de Estoque** (`MovimentacaoEstoque`): registros de abastecimento e retorno
- **Solicitações GEM** (`SolicitaGEM`): requisições de entrada ou saída de produtos

O minimundo e o DDL estão em `BD\comandos sql criar banco de dados.txt`; o documento de especificação detalha regras de negócio.

## 🚀 Tecnologias

- **Web server:** WampServer (Apache + MySQL/MariaDB)  - Dúividas para configurar? Deixei-as no fórum de discussão - link para acessar os controles: http://localhost/controle_quimicos/controles_php/
- **Back-end:** PHP 8+ (PDO)  
- **Banco de Dados:** MySQL (ou MariaDB)  
- **Front-end:** HTML5, CSS3, Java Script, Bootstrap 5 (via CDN ou scripts_css/)

## Destaques
- PDO significa PHP Data Objects.
É uma interface de acesso a banco de dados em PHP, criada para permitir que você trabalhe com vários bancos de dados usando o mesmo código básico, de forma segura e orientada a objetos. 
- **DAO (Data Access Object)**: Optei pois usei vários métodos e para faciliar manutenção futuras no código, a implantação dessa técnica em separar em um bloco distinto os aquivos que fariam acesso aos dados do banco, em comparação com os demais arquivos, que foram elaborados sem a preocupação dos códigos SQL, tabelas e conexões.  Basta chamar os métodos que a mágica fez acontecer.

## 🗂️ Estrutura de Pastas

```text
controle_quimicos/
├ config/
│   └ database.php              ← configuração de conexão PDO
├ controles_php/               ← controle por entidade
│   ├ ProdutoController.php
│   ├ PessoaController.php
│   ├ SupervisorController.php
│   ├ OperadorController.php
|   ├ OperacaoProducaoController.php
│   ├ RecipienteController.php
│   ├ TanqueOperacionalController.php
│   ├ MovimentacaoEstoqueController.php
│   └ SolicitaGEMController.php
├ classe_dados/                ← models CRUD em php
│   ├ ProdutoDado.php
│   ├ PessoaDado.php
│   ├ SupervisorDado.php
│   ├ OperadorDado.php
│   ├ RecipienteDado.php
│   ├ TanqueOperacionalDado.php
│   ├ MovimentacaoEstoqueDado.php
│   └ SolicitaGEMDado.php
├ templates_html/              ← views Bootstrap
├ BD
|   └ estrutura.sql            ←  obsoleto
|   └ comandos sql criar banco de dados.txt
├ Views                        ←  integração do portal com menu dinâmico (Bootstrap)
|   ├ Consulta
|   |  └ produtos.php   
│   ├ movimentacao_estoque
|   |  ├ form.php
|   |  └ list.php
│   ├ operacao_producao
|   |  ├ form.php
|   |  └ list.php
│   ├ operador
|   |  ├ form.php
|   |  └ list.php
│   ├ pessoa
|   |  ├ form.php
|   |  └ list.php
│   ├ produto
|   |  ├ form.php
|   |  └ list.php
│   ├ recipiente
|   |  ├ form.php
|   |  └ list.php
│   ├ solicita_gem
|   |  ├ form.php
|   |  └ list.php
│   ├ supervisor
|   |  ├ form.php
|   |  └ list.php
│   ├ tanque
|   |  ├ form.php
|   |  └ list.php
|   ├ cadastro_pessoa.php
|   ├ consulta_pessoa.php
|   ├ editar_pessoa.php
|   └ form_editar_pessoa.php
├ scripts_css/                 
├ testar_conexao.php           ← script simples para validar PDO
├ conexao.php                  ← arquivo central que cria a conexão PDO com o banco de dados
├ index.php                    ← arquivo principal que carrega as views dinamicamente via parâmetro ?pagina=...
└ estrutura.sql                ← DDL do banco de dados
