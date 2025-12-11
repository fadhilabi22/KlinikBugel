<div class="modal fade" id="modalResep" tabindex="-1" role="dialog" aria-labelledby="modalResepLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modalResepLabel">Tambah Resep Obat</h4>
            </div>
            
            <div class="modal-body">
                <form id="form-tambah-resep">
                    
                    <div class="form-group">
                        <label for="id_obat_select">Pilih Obat</label>
                        
                        <select class="form-control" id="id_obat_select" required style="width: 100%;">
                            <option value="">-- Cari Obat --</option>
                            <?php 
                            // Loop data dari M_Obat->get_all()
                            if(isset($list_obat) && is_array($list_obat)):
                                foreach($list_obat as $obat):
                                    $display_name = $obat->nama_obat . ' (' . $obat->satuan . ') - Stok: ' . $obat->stok;
                                    echo '<option value="'.$obat->id_obat.'" data-stok="'.$obat->stok.'">'.$display_name.'</option>';
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="jumlah_obat[]">Jumlah yang Diresepkan</label>
                        <input type="number" class="form-control" id="jumlah_obat"required>
                    </div>

                    <div class="form-group">
                        <label for="aturan_pakai">Aturan Pakai</label>
                        <input type="text" class="form-control" id="aturan_pakai" placeholder="Contoh: 3x sehari 1 tablet sesudah makan" required>
                    </div>

                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnTambahResep">Tambah ke Resep</button>
            </div>
        </div>
    </div>
</div>