const formulario = document.getElementById("formCadastro");
    const mensagem = document.getElementById("mensagem");
    const camposTexto = [
      document.getElementById("titulo"),
      document.getElementById("autor")
    ];

    camposTexto.forEach(campo => {
      campo.addEventListener("input", () => {
        campo.setCustomValidity("");
        campo.removeAttribute("aria-invalid");
        mensagem.textContent = "";
      });
    });

    formulario.addEventListener("submit", evento => {
      mensagem.textContent = "";

      for (const campo of camposTexto) {
        campo.value = campo.value.trim();

        if (!campo.value) {
          evento.preventDefault();
          campo.setCustomValidity("Preencha este campo com um texto válido.");
          campo.setAttribute("aria-invalid", "true");
          campo.reportValidity();
          return;
        }
      }

      if (window.location.protocol === "file:") {
        evento.preventDefault();
        mensagem.textContent =
          "Para enviar o cadastro, abra o projeto por um servidor PHP. " +
          "O arquivo php/cadastrar.php também precisa estar implementado.";
      }

    });
