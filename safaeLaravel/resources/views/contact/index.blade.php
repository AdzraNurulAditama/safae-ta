@extends('layouts.app')

@section('content')
<style>
    /* Anti Flex – memutus semua efek flex dari parent */
    .contact-wrapper {
        display: block !important;
        width: 100%;
    }

    .contact-card {
        max-width: 600px;
        margin: 40px auto;
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .contact-field {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }

    .contact-field input,
    .contact-field textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 10px;
        font-size: 16px;
    }

    .contact-btn {
        background: #2563eb;
        color: white;
        padding: 12px 20px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
    }

    .contact-btn:hover {
        background: #1e4fcf;
    }
</style>

<div class="contact-wrapper">

    <div class="contact-card">

        <h1 class="text-3xl font-bold mb-6">Contact Us</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST">
            @csrf

            <div class="contact-field">
                <label class="font-semibold mb-1">Name</label>
                <input type="text" name="name" placeholder="Enter your name">
            </div>

            <div class="contact-field">
                <label class="font-semibold mb-1">Email</label>
                <input type="email" name="email" placeholder="yourmail@example.com">
            </div>

            <div class="contact-field">
                <label class="font-semibold mb-1">Message</label>
                <textarea name="message" rows="5" placeholder="Write your message here..."></textarea>
            </div>

            <button type="submit" class="contact-btn">Send Message</button>

        </form>

    </div>

</div>
@endsection
