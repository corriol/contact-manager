# Formulari de contactes

En la següent activitat crearem un formulari per a recollir la informació dels nostres contactes.
Descarrega't la plantilla per a realitzar l'activitat.

## Pas 1. Creació del formulari

El formulari contindrà els següents camps:

* `firstname`
* `lastname`
* `phone`
* `email`
* `address`
* `city`
* `zipcode`

Tots els camps són obligatoris excepte `address`, `city` i `zipcode`.

## Pas 2. Processament del formulari

El formulari s'enviarà al mateix fitxer i mostrarà les dades enviades **en format de taula**.

## Pas 3. Validació del formulari.

Nota: si s'ha usat validació en el navegador (HTML5) cal desactivar-la afegint l'atribut `novalidate`a l'element `form`.

Caldrà realitzar les validacions ja indicades en el pas 1, més les següents:

* `firstname`, no pot superar els 25 caracters.
* `phone`, ha de contenir 9 digits (expressió regular: `^\d{9}$`).
* `email`, ha de ser una adreça electrònica correcta.
* `zipcode`, ha de contenir 5 dígits (expressió regular: `^\d{5}$`).

S'avaluaran tots els camps i si hi ha error/s caldrà mostrar-lo/s. Si no hi ha errors es mostraran les dades introduïdes per l'usuari.

## Pas 4. Manteniment de les dades vàlides

En cas d'error caldrà mostrar el formulari de nou però amb les dades vàlides que ha enviat l'usuari.


