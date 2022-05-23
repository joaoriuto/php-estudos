<main>
    <section>
        <a href="index.php">
            <button class="btn btn-success">Voltar</button>
        </a>
    </section>

    <h2 class="mt-4">Cadastrar vaga</h2>

    <form method="post">
        <div class="form-group">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" placeholder="Digite o título da vaga" required>
        </div>

        <div class="form-group">
            <label>Descrição</label>
            <textarea name="descricao" class="form-control" rows="5" placeholder="Digite a descrição da vaga" required></textarea>
        </div>

        <div class="form-group">
            <label>Status</label>

            <div>
                <div class="form-check form-check-inline">
                    <label>
                        <input type="radio" name="ativo" value="s" checked> Ativo                        
                    </label>
                </div>

                <div class="form-check form-check-inline">
                    <label>
                        <input type="radio" name="ativo" value="n"> Inativo                        
                    </label>
                </div>
        </div>

        <div>
            <button type="submit" class="btn btn-success">Enviar</button>
        </div>


    </form>

</main>