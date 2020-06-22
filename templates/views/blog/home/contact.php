<h1>Contact Form</h1>
<form action="/contact" enctype="multipart/form-data" method="POST">
    <div><input type="text" name="name" placeholder="Name"></div>
    <div><input type="text" name="age" placeholder="Age"></div>
    <div><input type="file" name="contact[post]" multiple></div>
    <button type="submit">Send</button>
</form>