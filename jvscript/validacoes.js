
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formFuncionario");

    form.addEventListener("submit", function (e) {
        // Limpar erros anteriores
        document.querySelectorAll(".error").forEach(span => span.textContent = "");

        const regexes = {
            nome: /^[A-ZÀ-Ý][a-zA-ZÀ-ÿ\s]+$/,
            grauRelacionamento: /^[A-Z][a-zA-Z]{2,}$/,
            nif: /^\d{9}$/,
            niss: /^\d{11}$/,
            cc: /^\d{9}[A-Z]{2}\d{1}$/,
            contacto: /^\d{9}$/,
            email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            remuneracao: /^\d+(\.\d{1,2})?$/, // aceita 1500, 1500.5 e 1500.75
            dependentes: /^\d+$/,
            iban: /^[A-Z]{2}\d{23}$/,
            continente: /^[0-9]{13,14}$/,
            matricula: /^([A-Z\d]{2})-([A-Z\d]{2})-([A-Z\d]{2})$/,
            letras: /^[A-Za-z\s]{2,}$/,
            moradaFiscal: /^([A-Za-zÀ-ÿ0-9ºª°.,\-\/ ]+),\s?\d+[A-Za-z]?,\s?\d{4}-\d{3},\s?[A-ZÁÉÍÓÚÂÊÎÔÛÃÕÇ][a-zà-ÿ]*(\s[A-Za-zÀ-ÿ]+)*$/
        };

        const campos = {
            nomeCompleto: "Nome completo inválido. (Primeira letra de cada palavra deve ser maiúscula)",
            nomeAbreviado: "Nome abreviado inválido. (Primeira letra de cada palavra deve ser maiúscula)",
            dataNascimento: "Idade superior a 100 anos ou data inválida.",
            moradaFiscal: "Morada fiscal inválida. (Ex: Rua Exemplo, 123, 4000-123, Porto)",
            cc: "Cartão de Cidadão inválido. (Ex: 123456789XZ1)",
            dataValidade: "Data de validade do Cartão de Cidadão inválida ou já expirou.",
            nif: "NIF inválido. (Deve conter apenas 9 digitos.)",
            niss: "NISS inválido. (Deve conter apenas 11 digitos.)",
            contactoPessoal: "Contacto pessoal inválido. (Deve conter apenas 9 digitos.)",
            contactoEmergencia: "Contacto de emergência inválido. (Deve conter apenas 9 digitos.)",
            grauRelacionamento: "Grau de relacionamento inválido.",
            email: "Email inválido.",
            dataInicioDeContrato: "Data de início inválida.",
            dataFimDeContrato: "Data de fim inválida.",
            remuneracao: "Remuneração inválida.",
            numeroDeDependentes: "Número de dependentes inválido.",
            IBAN: "IBAN inválido. (Deve conter duas letras e 23 digitos.)",
            cartaoContinente: "Número de Cartão Continente inválido. (Deve conter 13 a 14 digitos.)",
            matriculaDaViatura: "Matrícula da viatura inválida.",
            curso: "Curso inválido. (Deve começar por uma letra maiúscula e não pode conter números)",
            frequencia: "Frequência inválida. (Deve começar por uma letra maiúscula e não pode conter números)",
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

        if (!regexes.nome.test(getVal("nomeCompleto"))) {
            console.log("Regex falhou em nomeCompleto:", getVal("nomeCompleto"));  // linha adicionada
            setErro("nomeCompleto", campos.nomeCompleto);
        }
        if (!regexes.nome.test(getVal("nomeAbreviado"))) {
            console.log("Regex falhou em nomeAbreviado:", getVal("nomeAbreviado"));  // linha adicionada
            setErro("nomeAbreviado", campos.nomeAbreviado);
        }

        const nascimento = new Date(getVal("dataNascimento"));
        const hoje = new Date();
        const idade = hoje.getFullYear() - nascimento.getFullYear();
        if (isNaN(nascimento.getTime()) || idade < 0 || idade > 100) {
            console.log("Falha na validação da dataNascimento:", getVal("dataNascimento")); // linha adicionada
            setErro("dataNascimento", campos.dataNascimento);
        }

        if (!regexes.moradaFiscal.test(getVal("moradaFiscal"))) {
            console.log("Regex falhou em moradaFiscal:", getVal("moradaFiscal"));  // linha adicionada
            setErro("moradaFiscal", campos.moradaFiscal);
        }

        if (!regexes.cc.test(getVal("cc"))) {
            console.log("Regex falhou em cc:", getVal("cc"));  // linha adicionada
            setErro("cc", campos.cc);
        }

        const dataValidade = new Date(getVal("dataValidade"));
        if (isNaN(dataValidade.getTime()) || dataValidade <= hoje) {
            console.log("Falha na validação da dataValidade:", getVal("dataValidade"));  // linha adicionada
            setErro("dataValidade", campos.dataValidade);
        }

        if (!regexes.nif.test(getVal("nif"))) {
            console.log("Regex falhou em nif:", getVal("nif"));  // linha adicionada
            setErro("nif", campos.nif);
        }
        if (!regexes.niss.test(getVal("niss"))) {
            console.log("Regex falhou em niss:", getVal("niss"));  // linha adicionada
            setErro("niss", campos.niss);
        }

        if (!regexes.contacto.test(getVal("contactoPessoal"))) {
            console.log("Regex falhou em contactoPessoal:", getVal("contactoPessoal"));  // linha adicionada
            setErro("contactoPessoal", campos.contactoPessoal);
        }
        if (!regexes.contacto.test(getVal("contactoEmergencia"))) {
            console.log("Regex falhou em contactoEmergencia:", getVal("contactoEmergencia"));  // linha adicionada
            setErro("contactoEmergencia", campos.contactoEmergencia);
        }
        if (!regexes.grauRelacionamento.test(getVal("grauDeRelacionamento"))) {
            console.log("Regex falhou em grauDeRelacionamento:", getVal("grauDeRelacionamento"));  // linha adicionada
            setErro("grauDeRelacionamento", campos.grauRelacionamento);
        }

        if (!regexes.email.test(getVal("email"))) {
            console.log("Regex falhou em email:", getVal("email"));  // linha adicionada
            setErro("email", campos.email);
        }

        const inicio = new Date(getVal("dataInicioDeContrato"));
        const fim = new Date(getVal("dataFimDeContrato"));
        if (isNaN(inicio.getTime()) || isNaN(fim.getTime()) || inicio >= fim) {
            console.log("Falha na validação das datas do contrato:", getVal("dataInicioDeContrato"), getVal("dataFimDeContrato"));  // linha adicionada
            setErro("dataInicioDeContrato", campos.dataInicioDeContrato);
            setErro("dataFimDeContrato", campos.dataFimDeContrato);
        }

        if (!regexes.remuneracao.test(getVal("remuneracao"))) {
            console.log("Regex falhou em remuneracao:", getVal("remuneracao"));  // linha adicionada
            setErro("remuneracao", campos.remuneracao);
        }

        if (!regexes.dependentes.test(getVal("numeroDeDependentes"))) {
            console.log("Regex falhou em numeroDeDependentes:", getVal("numeroDeDependentes"));  // linha adicionada
            setErro("numeroDeDependentes", campos.numeroDeDependentes);
        }

        if (!regexes.iban.test(getVal("IBAN"))) {
            console.log("Regex falhou em IBAN:", getVal("IBAN"));  // linha adicionada
            setErro("IBAN", campos.IBAN);
        }

        if (!regexes.continente.test(getVal("cartaoContinente"))) {
            console.log("Regex falhou em cartaoContinente:", getVal("cartaoContinente"));  // linha adicionada
            setErro("cartaoContinente", campos.cartaoContinente);
        }
        if (!regexes.matricula.test(getVal("matriculaDaViatura"))) {
            console.log("Regex falhou em matriculaDaViatura:", getVal("matriculaDaViatura"));  // linha adicionada
            setErro("matriculaDaViatura", campos.matriculaDaViatura);
        }
        if (!regexes.letras.test(getVal("curso"))) {
            console.log("Regex falhou em curso:", getVal("curso"));  // linha adicionada
            setErro("curso", campos.curso);
        }
        if (!regexes.letras.test(getVal("frequencia"))) {
            console.log("Regex falhou em frequencia:", getVal("frequencia"));  // linha adicionada
            setErro("frequencia", campos.frequencia);
        }

        if (!formValido) {
            e.preventDefault();
        }
    
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formVoucher");

    if (!form) return;

    form.addEventListener("submit", function (e) {
        // Clear previous error messages
        document.querySelectorAll(".error").forEach(span => span.textContent = "");

        const campos = {
            dataExpiracao: "A validade deve ser de pelo menos 6 meses a partir de hoje.",
        };

        const getVal = name => document.querySelector(`[name="${name}"]`)?.value?.trim() || "";

        let formValido = true;

        function setErro(campo, msg) {
            const errorSpan = document.getElementById("error-" + campo);
            if (errorSpan) errorSpan.textContent = msg;
            formValido = false;
        }

        // Validação: dataExpiracao deve ser pelo menos 6 meses no futuro
        const dataInput = getVal("dataExpiracao");
        const dataValidade = new Date(dataInput);
        const hoje = new Date();
        hoje.setHours(0, 0, 0, 0); // normalize

        const seisMesesDepois = new Date(hoje);
        seisMesesDepois.setMonth(seisMesesDepois.getMonth() + 6);

        if (isNaN(dataValidade.getTime()) || dataValidade < seisMesesDepois) {
            setErro("dataExpiracao", campos.dataExpiracao);
        }

        if (!formValido) {
            e.preventDefault();
            console.log("Formulário de voucher inválido.");
        } else {
            console.log("Formulário de voucher válido. Enviando...");
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formConvidado");

    form.addEventListener("submit", function (e) {
        // Limpar erros anteriores
        document.querySelectorAll(".error").forEach(span => span.textContent = "");

        const regexes = {
            nome: /^[A-ZÀ-Ý][a-zA-ZÀ-ÿ\s]+$/,
            grauRelacionamento: /^[A-Z][a-zA-Z]{2,}$/,
            nif: /^\d{9}$/,
            niss: /^\d{11}$/,
            cc: /^\d{9}[A-Z]{2}\d{1}$/,
            contacto: /^\d{9}$/,
            email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            dependentes: /^\d+$/,
            iban: /^[A-Z]{2}\d{23}$/,
            continente: /^[0-9]{13,14}$/,
            matricula: /^([A-Z\d]{2})-([A-Z\d]{2})-([A-Z\d]{2})$/,
            letras: /^[A-Za-z\s]{2,}$/,
            moradaFiscal: /^([A-Za-zÀ-ÿ0-9ºª°.,\-\/ ]+),\s?\d+[A-Za-z]?,\s?\d{4}-\d{3},\s?[A-ZÁÉÍÓÚÂÊÎÔÛÃÕÇ][a-zà-ÿ]*(\s[A-Za-zÀ-ÿ]+)*$/
        };

        const campos = {
            nomeCompleto: "Nome completo inválido. (Primeira letra de cada palavra deve ser maiúscula)",
            nomeAbreviado: "Nome abreviado inválido. (Primeira letra de cada palavra deve ser maiúscula)",
            dataNascimento: "Idade superior a 100 anos ou data inválida.",
            moradaFiscal: "Morada fiscal inválida. (Ex: Rua Exemplo, 123, 4000-123, Porto)",
            cc: "Cartão de Cidadão inválido. (Ex: 123456789XZ1)",
            dataValidade: "Data de validade do Cartão de Cidadão inválida ou já expirou.",
            nif: "NIF inválido. (Deve conter apenas 9 digitos.)",
            niss: "NISS inválido. (Deve conter apenas 11 digitos.)",
            contactoPessoal: "Contacto pessoal inválido. (Deve conter apenas 9 digitos.)",
            contactoEmergencia: "Contacto de emergência inválido. (Deve conter apenas 9 digitos.)",
            grauRelacionamento: "Grau de relacionamento inválido.",
            email: "Email inválido.",
            numeroDeDependentes: "Número de dependentes inválido.",
            IBAN: "IBAN inválido. (Deve conter duas letras e 23 digitos.)",
            cartaoContinente: "Número de Cartão Continente inválido. (Deve conter 13 a 14 digitos.)",
            matriculaDaViatura: "Matrícula da viatura inválida.",
            curso: "Curso inválido. (Deve começar por uma letra maiúscula e não pode conter números)",
            frequencia: "Frequência inválida. (Deve começar por uma letra maiúscula e não pode conter números)",
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

        if (!regexes.nome.test(getVal("nomeCompleto"))) {
            console.log("Regex falhou em nomeCompleto:", getVal("nomeCompleto"));  // linha adicionada
            setErro("nomeCompleto", campos.nomeCompleto);
        }
        if (!regexes.nome.test(getVal("nomeAbreviado"))) {
            console.log("Regex falhou em nomeAbreviado:", getVal("nomeAbreviado"));  // linha adicionada
            setErro("nomeAbreviado", campos.nomeAbreviado);
        }

        const nascimento = new Date(getVal("dataNascimento"));
        const hoje = new Date();
        const idade = hoje.getFullYear() - nascimento.getFullYear();
        if (isNaN(nascimento.getTime()) || idade < 0 || idade > 100) {
            console.log("Falha na validação da dataNascimento:", getVal("dataNascimento")); // linha adicionada
            setErro("dataNascimento", campos.dataNascimento);
        }

        if (!regexes.moradaFiscal.test(getVal("moradaFiscal"))) {
            console.log("Regex falhou em moradaFiscal:", getVal("moradaFiscal"));  // linha adicionada
            setErro("moradaFiscal", campos.moradaFiscal);
        }

        if (!regexes.cc.test(getVal("cc"))) {
            console.log("Regex falhou em cc:", getVal("cc"));  // linha adicionada
            setErro("cc", campos.cc);
        }

        const dataValidade = new Date(getVal("dataValidade"));
        if (isNaN(dataValidade.getTime()) || dataValidade <= hoje) {
            console.log("Falha na validação da dataValidade:", getVal("dataValidade"));  // linha adicionada
            setErro("dataValidade", campos.dataValidade);
        }

        if (!regexes.nif.test(getVal("nif"))) {
            console.log("Regex falhou em nif:", getVal("nif"));  // linha adicionada
            setErro("nif", campos.nif);
        }
        if (!regexes.niss.test(getVal("niss"))) {
            console.log("Regex falhou em niss:", getVal("niss"));  // linha adicionada
            setErro("niss", campos.niss);
        }

        if (!regexes.contacto.test(getVal("contactoPessoal"))) {
            console.log("Regex falhou em contactoPessoal:", getVal("contactoPessoal"));  // linha adicionada
            setErro("contactoPessoal", campos.contactoPessoal);
        }
        if (!regexes.contacto.test(getVal("contactoEmergencia"))) {
            console.log("Regex falhou em contactoEmergencia:", getVal("contactoEmergencia"));  // linha adicionada
            setErro("contactoEmergencia", campos.contactoEmergencia);
        }
        if (!regexes.grauRelacionamento.test(getVal("grauDeRelacionamento"))) {
            console.log("Regex falhou em grauDeRelacionamento:", getVal("grauDeRelacionamento"));  // linha adicionada
            setErro("grauDeRelacionamento", campos.grauRelacionamento);
        }

        if (!regexes.email.test(getVal("email"))) {
            console.log("Regex falhou em email:", getVal("email"));  // linha adicionada
            setErro("email", campos.email);
        }

        if (!regexes.dependentes.test(getVal("numeroDeDependentes"))) {
            console.log("Regex falhou em numeroDeDependentes:", getVal("numeroDeDependentes"));  // linha adicionada
            setErro("numeroDeDependentes", campos.numeroDeDependentes);
        }

        if (!regexes.iban.test(getVal("IBAN"))) {
            console.log("Regex falhou em IBAN:", getVal("IBAN"));  // linha adicionada
            setErro("IBAN", campos.IBAN);
        }

        if (!regexes.continente.test(getVal("cartaoContinente"))) {
            console.log("Regex falhou em cartaoContinente:", getVal("cartaoContinente"));  // linha adicionada
            setErro("cartaoContinente", campos.cartaoContinente);
        }
        if (!regexes.matricula.test(getVal("matriculaDaViatura"))) {
            console.log("Regex falhou em matriculaDaViatura:", getVal("matriculaDaViatura"));  // linha adicionada
            setErro("matriculaDaViatura", campos.matriculaDaViatura);
        }
        if (!regexes.letras.test(getVal("curso"))) {
            console.log("Regex falhou em curso:", getVal("curso"));  // linha adicionada
            setErro("curso", campos.curso);
        }
        if (!regexes.letras.test(getVal("frequencia"))) {
            console.log("Regex falhou em frequencia:", getVal("frequencia"));  // linha adicionada
            setErro("frequencia", campos.frequencia);
        }

        if (!formValido) {
            e.preventDefault();
        }
    
    });
});