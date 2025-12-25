<div class="modal fade" id="modalTindakan" tabindex="-1" role="dialog" aria-labelledby="modalTindakanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modalTindakanLabel">Tambah Tindakan Medis</h4>
            </div>
            
            <div class="modal-body">
                <form id="form-tambah-tindakan">
                    
                    <div class="form-group">
                        <label for="id_tindakan_select">Pilih Tindakan</label>
                        <select class="form-control" id="id_tindakan_select" required style="width: 100%;">
                            <option value="">-- Cari Tindakan --</option>
                            <?php 
                            
                            if(isset($list_tindakan) && is_array($list_tindakan)):
                                foreach($list_tindakan as $tindakan):
                                    
                                    
                                    $biaya_murni = $tindakan->biaya_tindakan; 
                                    
                                    $display_name = $tindakan->nama_tindakan.' (Rp '.number_format($biaya_murni, 0, ',', '.').')';
                                    
                                    
                                    echo '<option value="'.$tindakan->id_tindakan.'" data-biaya="'.$biaya_murni.'">'.$display_name.'</option>';
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="catatan_tindakan">Catatan (Opsional)</label>
                        <input type="text" class="form-control" id="catatan_tindakan" placeholder="Detail atau keterangan tindakan">
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnTambahTindakan">Tambah ke Tindakan</button>
            </div>
        </div>
    </div>
</div>