
        document.addEventListener('DOMContentLoaded', () => {
            const reservationSection = document.getElementById('reservationSection');
            const paymentSection = document.getElementById('paymentSection');
            const reservationForm = document.getElementById('reservationForm');
            const customerInfoForm = document.getElementById('customerInfoForm');
            const confirmPaymentBtn = document.getElementById('confirmPaymentBtn');
            const checkInDateInput = document.getElementById('checkInDate');
            const checkOutDateInput = document.getElementById('checkOutDate');
            const roomTypeSelect = document.getElementById('roomType');
            const numAdultsSelect = document.getElementById('numAdults');
            const numChildrenSelect = document.getElementById('numChildren');
            const reservationSummary = document.getElementById('reservationSummary');
            const totalPriceSpan = document.getElementById('totalPrice');
            const extraOptionsCheckboxes = document.querySelectorAll('input[name="extraOptions"]');
            const messageBox = document.getElementById('messageBox');
            const messageText = document.getElementById('messageText');
            const paymentMessageBox = document.getElementById('paymentMessageBox');
            const paymentMessageText = document.getElementById('paymentMessageText');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const buttonText = document.getElementById('buttonText');

            let currentReservationDetails = {};
            let currentTotalPrice = 0;

            // Définir la date minimale pour la date d'arrivée à aujourd'hui
            const today = new Date();
            const todayISO = today.toISOString().split('T')[0];
            checkInDateInput.min = todayISO;

            // Mettre à jour la date minimale de départ lorsque la date d'arrivée change
            checkInDateInput.addEventListener('change', () => {
                const checkInDate = new Date(checkInDateInput.value);
                // La date de départ doit être au moins un jour après la date d'arrivée
                const nextDay = new Date(checkInDate);
                nextDay.setDate(checkInDate.getDate() + 1);
                checkOutDateInput.min = nextDay.toISOString().split('T')[0];

                // Si la date de départ actuelle est antérieure à la nouvelle date minimale, la réinitialiser
                if (checkOutDateInput.value && new Date(checkOutDateInput.value) < nextDay) {
                    checkOutDateInput.value = checkOutDateInput.min;
                }
            });

            // Gérer la soumission du formulaire de réservation (Étape 1)
            reservationForm.addEventListener('submit', (event) => {
                event.preventDefault();

                const checkInDate = new Date(checkInDateInput.value);
                const checkOutDate = new Date(checkOutDateInput.value);

                // Validation des dates
                if (checkOutDate <= checkInDate) {
                    showMessage('La date de départ doit être postérieure à la date d\'arrivée.', 'bg-red-100 text-red-700', messageBox, messageText);
                    return;
                }

                // Collecter les détails de la réservation
                const roomTypeOption = roomTypeSelect.options[roomTypeSelect.selectedIndex];
                const roomPricePerNight = parseFloat(roomTypeOption.dataset.price);
                const numNights = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
                const roomSubtotal = roomPricePerNight * numNights;
                const taxes = roomSubtotal * 0.10; // Exemple: 10% de taxes
                const fees = 5; // Exemple: frais de service fixes

                currentReservationDetails = {
                    checkIn: checkInDateInput.value,
                    checkOut: checkOutDateInput.value,
                    numAdults: numAdultsSelect.value,
                    numChildren: numChildrenSelect.value,
                    roomType: roomTypeOption.textContent.split('(')[0].trim(),
                    roomPricePerNight: roomPricePerNight,
                    numNights: numNights,
                    roomSubtotal: roomSubtotal,
                    taxes: taxes,
                    fees: fees,
                    extraOptions: []
                };

                updateReservationSummary();
                reservationSection.classList.add('hidden');
                paymentSection.classList.remove('hidden');
            });

            // Mettre à jour le récapitulatif et le prix total lorsque les options supplémentaires changent
            extraOptionsCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateReservationSummary);
            });

            function updateReservationSummary() {
                let summaryHtml = `
                    <p><span class="font-semibold">Type de chambre:</span> ${currentReservationDetails.roomType}</p>
                    <p><span class="font-semibold">Arrivée:</span> ${currentReservationDetails.checkIn}</p>
                    <p><span class="font-semibold">Départ:</span> ${currentReservationDetails.checkOut}</p>
                    <p><span class="font-semibold">Nuits:</span> ${currentReservationDetails.numNights}</p>
                    <p><span class="font-semibold">Adultes:</span> ${currentReservationDetails.numAdults}</p>
                    <p><span class="font-semibold">Enfants:</span> ${currentReservationDetails.numChildren}</p>
                    <p><span class="font-semibold">Prix de la chambre:</span> ${currentReservationDetails.roomSubtotal.toFixed(2)}€</p>
                    <p><span class="font-semibold">Taxes (10%):</span> ${currentReservationDetails.taxes.toFixed(2)}€</p>
                    <p><span class="font-semibold">Frais de service:</span> ${currentReservationDetails.fees.toFixed(2)}€</p>
                `;

                let extrasTotal = 0;
                currentReservationDetails.extraOptions = []; // Réinitialiser les options supplémentaires
                extraOptionsCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const extraPrice = parseFloat(checkbox.dataset.extraPrice);
                        let calculatedExtraPrice = extraPrice;
                        // Si c'est le petit-déjeuner, multiplier par le nombre d'adultes et de nuits
                        if (checkbox.id === 'breakfast') {
                            calculatedExtraPrice = extraPrice * parseInt(currentReservationDetails.numAdults) * currentReservationDetails.numNights;
                        }
                        summaryHtml += `<p><span class="font-semibold">${checkbox.parentNode.textContent.trim().split('(')[0].trim()}:</span> ${calculatedExtraPrice.toFixed(2)}€</p>`;
                        extrasTotal += calculatedExtraPrice;
                        currentReservationDetails.extraOptions.push({
                            name: checkbox.parentNode.textContent.trim().split('(')[0].trim(),
                            price: calculatedExtraPrice
                        });
                    }
                });

                currentTotalPrice = currentReservationDetails.roomSubtotal + currentReservationDetails.taxes + currentReservationDetails.fees + extrasTotal;
                reservationSummary.innerHTML = summaryHtml;
                totalPriceSpan.textContent = `${currentTotalPrice.toFixed(2)}€`;
            }

            // Gérer la soumission du paiement (Étape 2)
            confirmPaymentBtn.addEventListener('click', async () => {
                // Valider les informations client
                if (!customerInfoForm.checkValidity()) {
                    showMessage('Veuillez remplir toutes les informations client requises.', 'bg-red-100 text-red-700', paymentMessageBox, paymentMessageText);
                    customerInfoForm.reportValidity(); // Afficher les messages d'erreur du navigateur
                    return;
                }

                const selectedPaymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
                const firstName = document.getElementById('firstName').value;
                const lastName = document.getElementById('lastName').value;
                const email = document.getElementById('email').value;
                const phone = document.getElementById('phone').value;

                // Afficher le spinner de chargement et désactiver le bouton
                buttonText.textContent = 'Traitement...';
                loadingSpinner.classList.remove('hidden');
                confirmPaymentBtn.disabled = true;
                paymentMessageBox.classList.add('hidden'); // Cacher tout message précédent

                // Simuler l'appel API pour le paiement
                try {
                    const payload = {
                        reservationDetails: currentReservationDetails,
                        customerInfo: { firstName, lastName, email, phone },
                        paymentMethod: selectedPaymentMethod,
                        amount: currentTotalPrice.toFixed(2)
                    };

                    const apiKey = ""; // Laisser vide, Canvas fournira la clé si nécessaire
                    let apiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${apiKey}`;
                    let simulationMessage = '';

                    // Simuler des réponses différentes selon la méthode de paiement
                    switch (selectedPaymentMethod) {
                        case 'orangeMoney':
                            simulationMessage = 'Paiement Orange Money initié. Veuillez confirmer sur votre téléphone.';
                            // Exemple de simulation d'appel API pour Orange Money
                            // const orangeMoneyApiUrl = 'https://api.orangemoney.ci/payment';
                            // const orangeMoneyResponse = await fetch(orangeMoneyApiUrl, { method: 'POST', body: JSON.stringify(payload) });
                            // const orangeMoneyResult = await orangeMoneyResponse.json();
                            break;
                        case 'mtnMobileMoney':
                            simulationMessage = 'Paiement MTN Mobile Money en attente de confirmation.';
                            // Exemple de simulation d'appel API pour MTN Mobile Money
                            // const mtnMobileMoneyApiUrl = 'https://api.mtnmomo.cm/payment';
                            // const mtnMobileMoneyResponse = await fetch(mtnMobileMoneyApiUrl, { method: 'POST', body: JSON.stringify(payload) });
                            // const mtnMobileMoneyResult = await mtnMobileMoneyResponse.json();
                            break;
                        case 'ecobank':
                            simulationMessage = 'Redirection vers la passerelle de paiement Ecobank...';
                            // Exemple de simulation d'appel API pour Ecobank
                            // const ecobankApiUrl = 'https://api.ecobank.com/pay';
                            // const ecobankResponse = await fetch(ecobankApiUrl, { method: 'POST', body: JSON.stringify(payload) });
                            // const ecobankResult = await ecobankResponse.json();
                            break;
                        case 'creditCard':
                            simulationMessage = 'Paiement par carte de crédit en cours de traitement.';
                            // Simulation d'une réponse générique pour les autres méthodes
                            // const genericPaymentApiUrl = 'https://api.example.com/payment';
                            // const genericPaymentResponse = await fetch(genericPaymentApiUrl, { method: 'POST', body: JSON.stringify(payload) });
                            // const genericPaymentResult = await genericPaymentResponse.json();
                            break;
                        case 'paypal':
                            simulationMessage = 'Redirection vers PayPal pour finaliser le paiement.';
                            break;
                        default:
                            simulationMessage = 'Paiement en cours de traitement.';
                    }

                    // Simuler un délai de traitement de l'API
                    await new Promise(resolve => setTimeout(resolve, 2000));

                    // Afficher le message de simulation
                    showMessage(simulationMessage, 'bg-blue-100 text-blue-700', paymentMessageBox, paymentMessageText);

                    // Après un délai supplémentaire, simuler la confirmation finale
                    await new Promise(resolve => setTimeout(resolve, 3000));
                    showMessage('Paiement réussi ! Votre réservation est confirmée. Un email de confirmation a été envoyé.', 'bg-green-100 text-green-700', paymentMessageBox, paymentMessageText);

                    // Réinitialiser le formulaire et revenir à la première étape après un certain temps
                    setTimeout(() => {
                        reservationForm.reset();
                        customerInfoForm.reset();
                        extraOptionsCheckboxes.forEach(cb => cb.checked = false);
                        messageBox.classList.add('hidden');
                        paymentMessageBox.classList.add('hidden');
                        paymentSection.classList.add('hidden');
                        reservationSection.classList.remove('hidden');
                        checkInDateInput.min = todayISO;
                        checkOutDateInput.min = '';
                    }, 5000);

                } catch (error) {
                    console.error('Erreur lors du traitement du paiement:', error);
                    showMessage('Une erreur est survenue lors du paiement. Veuillez réessayer.', 'bg-red-100 text-red-700', paymentMessageBox, paymentMessageText);
                } finally {
                    // Cacher le spinner et réactiver le bouton
                    buttonText.textContent = 'Confirmer et Payer';
                    loadingSpinner.classList.add('hidden');
                    confirmPaymentBtn.disabled = false;
                }
            });

            function showMessage(message, classes, boxElement, textElement) {
                textElement.textContent = message;
                boxElement.className = `mt-8 p-4 rounded-md ${classes}`;
                boxElement.classList.remove('hidden');
            }
        });
   