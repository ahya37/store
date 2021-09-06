 <div class="row fixed-top">
             <div class="col-lg-12">
               <form action="{{ route('search-product') }}" method="POST">
                 @csrf
                 <div class="input-group">
                   <input
                     type="text"
                     class="form-control"
                     name="q"
                     placeholder="Cari Produk"
                   />
                   <div class="input-group-append">
                     <span class="input-group-text" id="basic-addon2"
                       ><i class="fa fa-search" aria-hidden="true"></i
                     ></span>
                   </div>
                 </div>
               </form>
             </div>
            </div>