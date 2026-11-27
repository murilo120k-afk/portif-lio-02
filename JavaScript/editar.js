    const formulario = document.getElementById("formEdicao");
    const mensagem = document.getElementById("mensagem");
    const estado = document.getElementById("estado");
    const campos = ["titulo", "autor", "categoria", "quantidade", "preco"];
    const id = new URLSearchParams(window.location.search).get("id");
    let carregado = false;
    let enviando = false;
    let iniciais = valores();

    function valores() {
      return Object.fromEntries(
        campos.map(nome => [nome, document.getElementById(nome).value])
      );
    }

    function alterado() {
      return JSON.stringify(valores()) !== JSON.stringify(iniciais);
    }

    function atualizarEstado() {
      estado.textContent = alterado() ? "Alterações não salvas" : "Sem alterações";
      estado.style.color = alterado() ? "var(--vermelho)" : "var(--verde)";
    }

    formulario.addEventListener("input", () => {
      ["titulo", "autor"].forEach(nome =>
        document.getElementById(nome).setCustomValidity("")
      );
      mensagem.textContent = "";
      atualizarEstado();
    });

    document.getElementById("restaurar").addEventListener("click", () => {
      campos.forEach(nome => {
        const campo = document.getElementById(nome);
        campo.value = iniciais[nome];
        campo.setCustomValidity("");
      });
      mensagem.textContent = "";
      atualizarEstado();
    });

    async function carregarLivro() {
      if (!id) return;

      if (!/^[1-9]\d*$/.test(id)) {
        mensagem.textContent = "O identificador do livro é inválido.";
        return;
      }

      estado.textContent = "Carregando registro…";
      document.getElementById("aviso").textContent =
        "Buscando os dados do livro no servidor.";
      const controles = [...formulario.querySelectorAll("input, select, button")];
      controles.forEach(controle => controle.disabled = true);

      try {
        const resposta = await fetch(
          "php/buscar_livro.php?id=" + encodeURIComponent(id),
          { headers: { Accept: "application/json" }, cache: "no-store" }
        );
        if (!resposta.ok) throw new Error("Falha ao carregar");
        const livro = await resposta.json();

        if (String(livro.id) !== id ||
            campos.some(nome => livro[nome] === undefined || livro[nome] === null)) {
          throw new Error("Resposta inválida");
        }

        campos.forEach(nome => {
          document.getElementById(nome).value = String(livro[nome]);
        });
        document.getElementById("livroId").value = id;
        iniciais = valores();
        carregado = true;
        document.getElementById("registro").textContent = "Livro · Registro #" + id;
        document.getElementById("aviso").textContent =
          "Dados carregados. Ao salvar, o formulário enviará as alterações para php/atualizar.php.";
        atualizarEstado();
      } catch (erro) {
        mensagem.textContent =
          "Não foi possível carregar o livro. Verifique se php/buscar_livro.php existe e retorna os dados em JSON.";
        estado.textContent = "Registro indisponível";
        document.getElementById("aviso").textContent =
          "Os valores exibidos são exemplos. O salvamento está bloqueado até carregar um registro real.";
      } finally {
        controles.forEach(controle => controle.disabled = false);
      }
    }

    formulario.addEventListener("submit", evento => {
      mensagem.textContent = "";

      for (const nome of ["titulo", "autor"]) {
        const campo = document.getElementById(nome);
        campo.value = campo.value.trim();
        if (!campo.value) {
          evento.preventDefault();
          campo.setCustomValidity("Preencha este campo com um texto válido.");
          campo.reportValidity();
          return;
        }
      }

      if (window.location.protocol === "file:" || !carregado) {
        evento.preventDefault();
        mensagem.textContent =
          "Nenhuma alteração foi salva. Abra a página em um servidor PHP com o ID de um livro e configure os endpoints de busca e atualização.";
        return;
      }

      enviando = true;
    });

    window.addEventListener("beforeunload", evento => {
      if (alterado() && !enviando) {
        evento.preventDefault();
        evento.returnValue = "";
      }
    });

    carregarLivro();
