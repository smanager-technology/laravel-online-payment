<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel - Demo Payment</title>

    <x-favicon/>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous">
</head>
<body>

<!-- HEADER: MENU + HERO SECTION -->
<header></header>

<section class="container">
    <div class="row mt-2">
        <div class="col-md-6 mx-auto pt-3 border border-success bg-light text-dark">
            <div class="text-center">
                <img src="{{ asset('public/light.png') }}"
                     width="100px"
                     alt="sManager Technology" />
                <h3>Your Information</h3>
            </div>

            <div class="row">
                <div class="col-sm" id="errorDiv">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @elseif($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <form action="{{ url('payment') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label><span class="text-danger">*</span>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           aria-describedby="nameHelpBlock"
                           value="{{ old('name') }}"
                           name="name"
                           id="name">
                    @error('name')
                    <small id="nameHelpBlock" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="row">
                    <div class="mb-3 col-md">
                        <label for="phone" class="form-label">Contact No.</label><span class="text-danger">*</span>
                        <input type="text"
                               class="form-control @error('phone') is-invalid @enderror"
                               aria-describedby="phoneHelpBlock"
                               value="{{ old('phone') }}"
                               name="phone"
                               id="phone">
                        @error('phone')
                        <small id="phoneHelpBlock" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3 col-md">
                        <label for="email" class="form-label">Email</label>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               aria-describedby="emailHelpBlock"
                               value="{{ old('email') }}"
                               name="email"
                               id="email">
                        @error('email')
                        <small id="emailHelpBlock" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror"
                              id="address"
                              name="address"
                              aria-describedby="addressHelpBlock"
                              rows="2">{{ old('address') }}</textarea>
                    @error('address')
                    <small id="addressHelpBlock" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount</label><span class="text-danger">*</span>
                    <input type="text"
                           class="form-control @error('amount') is-invalid @enderror"
                           aria-describedby="amountHelpBlock"
                           value="{{ old('amount') }}"
                           name="amount"
                           id="amount">
                    @error('amount')
                    <small id="amountHelpBlock" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="float-end mb-2">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- FOOTER: DEBUG INFO + COPYRIGHTS -->

<footer></footer>

<!-- SCRIPTS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>
