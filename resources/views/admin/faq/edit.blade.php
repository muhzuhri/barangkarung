@include('admin.layout.header')
<title>Edit FAQ | BK</title>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit FAQ</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.faq.index') }}" class="btn btn-secondary btn-sm">
                            Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.faq.update', $faq) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="category">Kategori</label>
                            <input type="text" name="category" id="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category', $faq->category) }}" required>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="question">Pertanyaan</label>
                            <input type="text" name="question" id="question" class="form-control @error('question') is-invalid @enderror" value="{{ old('question', $faq->question) }}" required>
                            @error('question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="answer">Jawaban</label>
                            <textarea name="answer" id="answer" rows="5" class="form-control @error('answer') is-invalid @enderror" required>{{ old('answer', $faq->answer) }}</textarea>
                            @error('answer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" {{ old('is_active', $faq->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Aktif</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.layout.footer')