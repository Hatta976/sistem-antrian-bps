<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Antrean BPS Kota Prabumulih</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(135deg, #003366, #0059B3); height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card-login { width: 100%; max-width: 420px; border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
    </style>
</head>
<body>

<div class="card card-login p-4">
    <div class="text-center mb-4">
        <i class="bi bi-building-fill text-warning display-4"></i>
        <h4 class="fw-bold mt-2 text-primary">PST BPS PRABUMULIH</h4>
        <p class="text-muted small">Sistem Manajemen Antrean Pelayanan</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('login.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label font-weight-bold">Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control" placeholder="admin@bpsprabumulih.go.id" required value="{{ old('email') }}">
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label font-weight-bold">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="background-color: #003366;">
            <i class="bi bi-box-arrow-in-right me-2"></i> Masuk Sistem
        </button>
    </form>
</div>

</body>
</html>