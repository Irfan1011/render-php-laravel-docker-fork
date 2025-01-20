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

                <form action="{{ route('promo.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Promo Code</label>
                    <select class="form-select" name="promo_code" id="promo_code" required>
                        <option value="MHS" <?= old('promo_code') == "MHS" ? "selected" : ""?>>MHS</option>
                        <option value="BDAY" <?= old('promo_code') == "BDAY" ? "selected" : ""?>>BDAY</option>
                        <option value="MDK" <?= old('promo_code') == "MDK" ? "selected" : ""?>>MDK</option>
                        <option value="WKN" <?= old('promo_code') == "WKN" ? "selected" : ""?>>WKN</option>
                    </select>
                    <x-input-error :messages="$errors->get('promo_code')" class="mt-2" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Promo Type</label>
                    <select class="form-select" name="promo_type" id="promo_type" required>
                        <option value="Pelajar & Mahasiswa"
                            <?= old('promo_type') == "Pelajar & Mahasiswa" ? "selected" : ""?>>Pelajar & Mahasiswa
                        </option>
                        <option value="Ulang Tahun" <?= old('promo_type') == "Ulang Tahun" ? "selected" : ""?>>Ulang
                            Tahun</option>
                        <option value="Mudik" <?= old('promo_type') == "Mudik" ? "selected" : ""?>>Mudik</option>
                        <option value="Weekend" <?= old('promo_type') == "Weekend" ? "selected" : ""?>>Weekend</option>
                    </select>
                    <x-input-error :messages="$errors->get('promo_type')" class="mt-2" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Discount</label>
                    <input id="discount" class="block w-full" type="number" name="discount" placeholder="Discount%" value="{{old('discount')}}" required/>
                    <x-input-error :messages="$errors->get('discount')" class="mt-2" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" placeholder="Desc" rows="2" id="description" name="description"
                        required>{{old('description')}}</textarea>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-outline-primary" name="register">Submit</button>
                </div>
                </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>