 <section id="contact">
     <div class="contact-box position-relative z-2" data-aos="fade-left">
         <div class="contact-links">
             <h2>@lang('CONTACT')</h2>
             <div class="links">
                 <div class="link">
                    <a href="{{ Settings::get('linkedin') }}">
                        <div class="icon-form">
                            <img src=" {{ asset('assets/img/linkedin.svg') }} " alt="linkedin">
                        </div>
                    </a>
                 </div>
                 <div class="link">
                    <a href="{{ Settings::get('facebook') }}">
                        <div class="icon-form">
                            <img src=" {{ asset('assets/img/facebook.svg') }} " alt="facebook">
                        </div>
                    </a>
                 </div>
                 <div class="link">
                    <a href="{{ Settings::get('snapchat') }}">
                        <div class="icon-form">
                            <img src=" {{ asset('assets/img/snapchat.svg') }} " alt="snapchat">
                        </div>
                    </a>
                 </div>
                 <div class="link">
                    <a href="{{ Settings::get('gmail') }}">
                        <div class="icon-form">
                            <img src=" {{ asset('assets/img/gmail.svg') }} " alt="gmail">
                        </div>
                    </a>
                 </div>
             </div>
         </div>
         <div class="contact-form-wrapper">
             <form action="{{ route('contact.post') }}" method="post" id="Massage_form">
                @csrf
                <div class="form-item">
                    <span class="error-message"></span>
                    <input class="contact_input" type="text" name="name" required>
                    <label>@lang('Name'):</label>
                </div>
                <div class="form-item">
                    <span class="error-message"></span>
                    <input class="contact_input" type="text" name="email" required>
                    <label>@lang('Email'):</label>
                </div>
                <div class="form-item">
                    <span class="error-message"></span>
                    <input class="contact_input" type="tel" name="phone" required>
                    <label>@lang('Phone'):</label>
                </div>
                <div class="form-item">
                    <span class="error-message"></span>
                    <textarea class="contact_input" name="message" required></textarea>
                    <label>@lang('Message'):</label>
                </div>
                <div class="d-flex align-items-end btn_and_message">
                    <button class="submit-btn custom-btn btn-4" id="MassageBtnForm">@lang('Send')</button>
                </div>
             </form>
         </div>
     </div>
     <div id="message" class="mb-3 message">
        <div class="message-content">
            <div class="message-header">
                <h2 class="message-title m-0"></h2>
                <button class="message-close" onclick="hideMessage()">&times;</button>
            </div>
            <p class="message-text mb-0"></p>
            <div class="progress-bar">
                <div class="progress"></div>
            </div>
        </div>
    </div>
 </section>

 <script>
    // dropdown
    function toggleDropdown() {
        var dropdown = document.getElementById("myDropdown");
        if (dropdown.style.display === "block") {
            dropdown.style.animation = "fade-out 0.5s ease-in-out";
            setTimeout(function() {
            dropdown.style.display = "none";
            }, 500);
            document.removeEventListener("click", closeDropdown);
        } else {
            dropdown.style.display = "block";
            dropdown.style.animation = "fade-in 0.5s ease-in-out";
            document.addEventListener("click", closeDropdown);
        }
    }

    function closeDropdown(event) {
        var dropdown = document.getElementById("myDropdown");
        if (!event.target.matches('.dropbtn')) {
            dropdown.style.animation = "fade-out 0.5s ease-in-out";
            setTimeout(function() {
            dropdown.style.display = "none";
            }, 500);
            document.removeEventListener("click", closeDropdown);
        }
    }

    let selectedOption = document.getElementById("selectedOption");
    document.querySelectorAll('.dropdown-content li').forEach(e => {
        e.addEventListener('click', function(w) {
            selectedOption.value = this.innerText;
        })
    });


    // catch data and send api
    const form = document.getElementById('Massage_form');
    const btnform = document.getElementById('MassageBtnForm');
    const messagePop = document.getElementById('message');
    const progressBar = document.querySelector('.progress');
    const inputs = form.querySelectorAll('.contact_input');


    function showMessage(title, text, time) {
        const messageTitle = document.querySelector('.message-title');
        const messageText = document.querySelector('.message-text');
        messageTitle.textContent = title;
        messageText.textContent = text;
        messagePop.style.display = 'block';
        let width = 0;
        const interval = setInterval(() => {
            width += 100 / (time * 1000 / 10);
            progressBar.style.width = `${width}%`;
            if (width >= 100) {
                clearInterval(interval);
                setTimeout(() => {
                    hideMessage();
                }, 10);
            }
        }, 10);
    }

    function hideMessage() {
        messagePop.style.display = 'none';
        progressBar.style.width = '0%';
    }

    btnform.addEventListener('click', (event) => {
        event.preventDefault();

        // start validation
        inputs.forEach(input => {
            input.value == '' && validateInput(input)
        });
        inputs.forEach(input => {
            if (input.value == '') {
                hasError = true
                return;
            } else {
                hasError = false
            }
        });

        if (!hasError) {
            console.log('Message sent');
            const name = form.elements['name'].value;
            const phone = form.elements['phone'].value;
            // const code = form.elements['code'].value;
            const email = form.elements['email'].value;
            const message = form.elements['message'].value;

            const data = {
                name,
                phone,
                // code,
                email,
                message
            };

            btnform.disabled = true;
            const baseUrl = window.location.origin;
            fetch(`${baseUrl}/contact`, {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                showMessage('',data.message,4)
                btnform.disabled = false;
                if (data.success) {
                    form.elements['name'].value =''
                    form.elements['phone'].value =''
                    form.elements['email'].value =''
                    form.elements['message'].value =''
                    document.querySelectorAll('#contact .from-group input, #contact .from-group textarea').forEach((e) => {
                        e.classList.remove('active')
                    })
                }
            })
            .catch(error => {
                console.log(error);
                btnform.disabled = false;
            });
        }
    });

    const errorMessages = form.querySelectorAll('.error-message');
    let hasError = false

    function validateInput(input,removeMessage=false) {
        const validationType = input.dataset.validation;
        const error = input.previousElementSibling;

        if (input.validity.valid || removeMessage) {
            error.textContent = '';
            error.className = 'error-message';
        } else {
            hasError = true
            switch (validationType) {
                case 'name':
                    error.textContent = 'Please enter a valid name';
                    break;
                case 'phone':
                    error.textContent = 'Please enter a valid phone number';
                    break;
                case 'email':
                    error.textContent = 'Please enter a valid email address';
                    break;
                case 'message':
                    error.textContent = 'Please enter a message';
                    break;
                default:
                    error.textContent = 'Please enter a valid value';
            }
            error.className = 'error-message active';
        }
    }

    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            validateInput(input,true);
        });
    });

</script>
