<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Promo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                <form action="{{ route('promo.update',$promo->promo_code) }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label class="form-label">Promo Code</label>
                    <select class="form-select" name="promo_code" id="promo_code" required>
                        <option value="MHS" <?= $promo->promo_code == "MHS" ? "selected" : ""?>>MHS</option>
                        <option value="BDAY" <?= $promo->promo_code == "BDAY" ? "selected" : ""?>>BDAY</option>
                        <option value="MDK" <?= $promo->promo_code == "MDK" ? "selected" : ""?>>MDK</option>
                        <option value="WKN" <?= $promo->promo_code == "WKN" ? "selected" : ""?>>WKN</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Promo Type</label>
                    <select class="form-select" name="promo_type" id="promo_type" required>
                        <option value="Pelajar & Mahasiswa"
                            <?= $promo->promo_type == "Pelajar & Mahasiswa" ? "selected" : ""?>>Pelajar & Mahasiswa
                        </option>
                        <option value="Ulang Tahun" <?= $promo->promo_type == "Ulang Tahun" ? "selected" : ""?>>Ulang
                            Tahun</option>
                        <option value="Mudik" <?= $promo->promo_type == "Mudik" ? "selected" : ""?>>Mudik</option>
                        <option value="Weekend" <?= $promo->promo_type == "Weekend" ? "selected" : ""?>>Weekend
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" rows="2" id="description" name="description"
                        required>{{$promo->description}}</textarea>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </div>
                </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>