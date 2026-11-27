document.addEventListener("DOMContentLoaded", () => {
  const listaLivros = document.getElementById("listaLivros");
  const pesquisa = document.getElementById("pesquisa");
  const resultado = document.getElementById("resultado");
  const totalLivros = document.getElementById("totalLivros");
  const totalEstoque = document.getElementById("totalEstoque");
  const mensagem = document.getElementById("mensagem");

  const url = "../PHP/listar.php";

  let livros = [];

  /*
   * Exibe a mensagem enviada pelo PHP.
   *
   * Exemplo de URL:
   * index.html?mensagem=Livro%20cadastrado%20com%20sucesso%21
   */
  const parametros = new URLSearchParams(window.location.search);
  const textoMensagem = parametros.get("mensagem");

  if (textoMensagem && mensagem) {
    mensagem.textContent = textoMensagem;
    mensagem.classList.add("visivel");

    setTimeout(() => {
      mensagem.classList.remove("visivel");
    }, 5000);

    // Remove ?mensagem=... da URL sem recarregar a página.
    window.history.replaceState(
      {},
      document.title,
      window.location.pathname
    );
  }

  function exibirMensagemTabela(texto) {
    const linha = document.createElement("tr");
    const celula = document.createElement("td");

    celula.colSpan = 4;
    celula.textContent = texto;

    linha.appendChild(celula);
    listaLivros.replaceChildren(linha);
  }

  function mostrarLivros(livrosFiltrados) {
    listaLivros.replaceChildren();

    if (livrosFiltrados.length === 0) {
      exibirMensagemTabela("Nenhum livro encontrado.");
      resultado.textContent = "Nenhum resultado encontrado.";
      return;
    }

    const fragmento = document.createDocumentFragment();

    livrosFiltrados.forEach((livro) => {
      const linha = document.createElement("tr");

      const colunaId = document.createElement("td");
      const colunaTitulo = document.createElement("td");
      const colunaAutor = document.createElement("td");
      const colunaQuantidade = document.createElement("td");

      colunaId.textContent = livro.id ?? "";
      colunaTitulo.textContent = livro.titulo ?? "";
      colunaAutor.textContent = livro.autor ?? "";
      colunaQuantidade.textContent = livro.quantidade ?? 0;

      linha.append(
        colunaId,
        colunaTitulo,
        colunaAutor,
        colunaQuantidade
      );

      fragmento.appendChild(linha);
    });

    listaLivros.appendChild(fragmento);

    resultado.textContent =
      `${livrosFiltrados.length} livro(s) encontrado(s).`;
  }

  function atualizarIndicadores() {
    totalLivros.textContent = livros.length;

    const estoque = livros.reduce((total, livro) => {
      return total + Number(livro.quantidade || 0);
    }, 0);

    totalEstoque.textContent = estoque;
  }

  function filtrarLivros() {
    const termo = pesquisa.value.trim().toLowerCase();

    const livrosFiltrados = livros.filter((livro) => {
      const titulo = String(livro.titulo || "").toLowerCase();
      return titulo.includes(termo);
    });

    mostrarLivros(livrosFiltrados);
  }

  async function carregarLivros() {
    exibirMensagemTabela("Carregando livros...");

    try {
      const resposta = await fetch(url, {
        method: "GET",
        headers: {
          Accept: "application/json"
        },
        cache: "no-store"
      });

      if (!resposta.ok) {
        throw new Error("Erro HTTP: " + resposta.status);
      }

      const dados = await resposta.json();

      if (!Array.isArray(dados)) {
        throw new Error("A resposta do PHP não é uma lista de livros.");
      }

      livros = dados;

      atualizarIndicadores();
      mostrarLivros(livros);
    } catch (erro) {
      console.error(erro);

      exibirMensagemTabela(
        "Não foi possível carregar os livros."
      );

      resultado.textContent =
        "Verifique se o Apache, o MySQL e o arquivo listar.php estão funcionando.";
    }
  }

  pesquisa.addEventListener("input", filtrarLivros);

  carregarLivros();
});
