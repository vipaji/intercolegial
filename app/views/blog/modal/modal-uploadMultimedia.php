<!-- Modal Upload foto -->
<div class="modal fade" id="UploadImagem" tabindex="-1" role="dialog" aria-labelledby="UploadTitulo" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-file-o fa-1x"></i> Carregar foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" id="label-erro" style="display:none;">
                    <strong></strong> <span id="info-erro"></span> <a href="#" class="alert-link"></a>
                </div>
                <form id="upload-multimedia" class="dropzone"  method="POST" action="<?= $v_page_url ?>uploadMultimedia" enctype="multipart/form-data">
                     <input name="file[]" id="multiplos" type="file" multiple />
                    <input type="hidden" id="id_produto" name="id_produto" value="<?= base64_encode($v_entity->getId()); ?>">  
                </form>
            </div>
            <div class="modal-footer">
                <button id = "submit-upload" type="button" class="btn btn-success" onclick="return verificar();">Gravar</button>
                <button class="btn btn-default" type="reset">Limpar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

            </div>
        </div>

    </div>
</div>

<script>
    function verificar()
    {
        if($("#multiplos").val()=="")
        {
            $("#label-erro").show();
            $("#info-erro").text("A caixa não pode estar vazia.");
            return false;
        }
        else
        {
            var form = document.getElementById("upload-multimedia");
            document.getElementById("submit-upload").addEventListener("click", function () {
                form.submit();
            });return true;
        }
        
    }
</script>
<!-- // Modal Upload imagem -->