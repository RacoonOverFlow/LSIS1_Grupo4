document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formFuncionario");

    form.addEventListener("submit", function (e) {
        // Limpar erros anteriores
        document.querySelectorAll(".error").forEach(span => span.textContent = "");

        const regexes = {
            nome: /^[A-Z][a-zA-Z\s]+$/,
            grauRelacionamento: /^[A-Z][a-zA-Z]{2,}$/,
            nif: /^\d{9}$/,
            niss: /^\d{11}$/,
            cc: /^\d{9}[A-Z]{2}\d{1}$/,
            contacto: /^\d{9}$/,
            email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            remuneracao: /^\d+$/,
            dependentes: /^\d+$/,
            iban: /^PT50\d{21}$/,
            continente: /^\d{13,14}$/,
            matricula: /^\d{2}-[A-Z]{2}-\d{2}$/,
            letras: /^[A-Za-z\s]{2,}$/,
            moradaFiscal: /^([A-Za-zÀ-ÿ0-9ºª°.,\-\/ ]+),\s?\d+[A-Za-z]?,\s?\d{4}-\d{3},\s?[A-Za-zÀ-ÿ\s]+$/,
        };

        const campos = {
            nomeCompleto: "Nome completo inválido.",
            nomeAbreviado: "Nome abreviado inválido.",
            dataNascimento: "Idade superior a 100 anos ou data inválida.",
            moradaFiscal: "Morada fiscal inválida. (Ex: Rua Exemplo, 123, 4000-123, Porto)",
            cc: "Cartão de Cidadão inválido.",
            dataValidade: "Data de validade do Cartão de Cidadão inválida ou já expirou.",
            nif: "NIF inválido.",
            niss: "NISS inválido.",
            contactoPessoal: "Contacto pessoal inválido.",
            contactoEmergencia: "Contacto de emergência inválido.",
            grauRelacionamento: "Grau de relacionamento inválido.",
            email: "Email inválido.",
            dataInicioDeContrato: "Data de início inválida.",
            dataFimDeContrato: "Data de fim inválida.",
            remuneracao: "Remuneração inválida.",
            numeroDependentes: "Número de dependentes inválido.",
            IBAN: "IBAN inválido.",
            cartaoContinente: "Número de Cartão Continente inválido.",
            matriculaDaViatura: "Matrícula da viatura inválida.",
            curso: "Curso inválido.",
            frequencia: "Frequência inválida.",
        };

        const getVal = name => document.querySelector(`[name="${name}"]`)?.value?.trim() || "";

        let formValido = true;

        // Função para setar erro em campo
        function setErro(campo, msg) {
            const errorSpan = document.getElementById("error-" + campo);
            if (errorSpan) errorSpan.textContent = msg;
            formValido = false;
        }

        // Validações campo a campo com mensagem ao lado

        if (!regexes.nome.test(getVal("nomeCompleto"))) setErro("nomeCompleto", campos.nomeCompleto);
        if (!regexes.nome.test(getVal("nomeAbreviado"))) setErro("nomeAbreviado", campos.nomeAbreviado);

        const nascimento = new Date(getVal("dataNascimento"));
        const hoje = new Date();
        const idade = hoje.getFullYear() - nascimento.getFullYear();
        if (isNaN(nascimento.getTime()) || idade < 0 || idade > 100) setErro("dataNascimento", campos.dataNascimento);

        if (!regexes.moradaFiscal.test(getVal("moradaFiscal"))) setErro("moradaFiscal", campos.moradaFiscal);

        if (!regexes.cc.test(getVal("cc"))) setErro("cc", campos.cc);

        const dataValidade = new Date(getVal("dataValidade"));
        if (isNaN(dataValidade.getTime()) || dataValidade <= hoje) setErro("dataValidade", campos.dataValidade);

        if (!regexes.nif.test(getVal("nif"))) setErro("nif", campos.nif);
        if (!regexes.niss.test(getVal("niss"))) setErro("niss", campos.niss);

        if (!regexes.contacto.test(getVal("contactoPessoal"))) setErro("contactoPessoal", campos.contactoPessoal);
        if (!regexes.contacto.test(getVal("contactoEmergencia"))) setErro("contactoEmergencia", campos.contactoEmergencia);
        if (!regexes.grauRelacionamento.test(getVal("grauDeRelacionamento"))) setErro("grauDeRelacionamento", campos.grauRelacionamento);

        if (!regexes.email.test(getVal("email"))) setErro("email", campos.email);

        const inicio = new Date(getVal("dataInicioDeContrato"));
        const fim = new Date(getVal("dataFimDeContrato"));
        if (isNaN(inicio.getTime()) || isNaN(fim.getTime()) || inicio >= fim) {
            setErro("dataInicioDeContrato", campos.dataInicioDeContrato);
            setErro("dataFimDeContrato", campos.dataFimDeContrato);
        }

        if (!regexes.remuneracao.test(getVal("remuneracao"))) setErro("remuneracao", campos.remuneracao);
        if (!regexes.dependentes.test(getVal("numeroDependentes"))) setErro("numeroDependentes", campos.numeroDependentes);
        if (!regexes.iban.test(getVal("IBAN"))) setErro("IBAN", campos.IBAN);
        if (!regexes.continente.test(getVal("cartaoContinente"))) setErro("cartaoContinente", campos.cartaoContinente);
        if (!regexes.matricula.test(getVal("matriculaDaViatura"))) setErro("matriculaDaViatura", campos.matriculaDaViatura);
        if (!regexes.letras.test(getVal("curso"))) setErro("curso", campos.curso);
        if (!regexes.letras.test(getVal("frequencia"))) setErro("frequencia", campos.frequencia);

/*         if (!formValido) e.preventDefault(); */
    });
});
