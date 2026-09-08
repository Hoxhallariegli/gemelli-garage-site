# Plani i Rikonstruksionit Manual "Gemelli Garage PRO"

Ky plan detajon hapat për të rregulluar të gjitha problemet e hasura në projektin **Gemelli Garage**, duke u bazuar në logjikën e Livewire dhe duke eliminuar gabimet e gjenerimit automatik.

## 1. Mbrojtja dhe Ngarkimi i Imazheve (Persistent & Load)
- **Problemi:** Gjatë Update-it, imazhi fshihet nëse nuk ngarkohet një i ri. Shpesh nuk bëhet load imazhi aktual.
- **Zgjidhja Teknike:**
    - **Flutter Update:** Në `_save()`, fusha e imazhit do të fshihet nga payload-i nese `_imagePath == null`. Nuk do të dërgohet fare drejt serverit.
    - **Laravel Update:** Kontrollori do të përdorë `unset($data['image'])` nese nuk ka file të ri në request.
    - **Logo Detection:** Fusha `logo` (te VehicleBrand) do të trajtohet si imazh (Image Picker) dhe jo si tekst.
    - **Visual Fix:** Përdorimi i `BoxFit.contain` brenda kornizës që mjeti të shihet i plotë.
    - **Load Check:** Sigurimi që imazhi aktual i serverit të shfaqet në kornizë sapo hapet faqja Edit.

## 2. Relacionet Inteligjente (Dropdowns & Auto-Selection)
- **Problemi:** Listat dalin bosh dhe nuk bëhet auto-select vlera aktuale.
- **Zgjidhja Teknike:**
    - **Endpoints:** Përdorimi i rrugëve të sakta: `/vehicle-brands`, `/vehicle-models`, `/clients`, `/services`.
    - **Data Handling:** Mbështetje për formatin `response['data']` dhe listën e thjeshtë.
    - **Auto-Select:** Thirrja e `_loadData()` në `initState` dhe krahasimi `e['id'].toString() == selectedId.toString()`.
    - **License Plate Priority:** Te mjetet, do të shfaqet gjithmonë **Targa** në vend të ID-së (te listat dhe dropdowns).

## 3. Përmirësimi i UI dhe Pastrimi i Fushave (Livewire Style)
- **Headers:** Titujt do të jenë: `"Shto [Moduli]"` dhe `"Edito [Moduli]"`.
- **System Fields Removal:** Do të hiqen të gjitha fushat që nuk krijohen manualisht:
    - `public_token`, `token`, `remember_token`.
    - `created_at`, `updated_at`, `deleted_at`.
    - `slug`, `last_activity`, etj.
- **JSON Translations:** Për fushat si `name` (te Shërbimet) që janë JSON, do të shfaqet automatikisht versioni shqip `name['sq']`.
- **Enums/Status:** Për statuset (psh. te Jobs) do të përdoren butona zgjedhjeje (ChoiceChips) me vlerat e saktë: `pending`, `in_progress`, `completed`, `cancelled`.

## 4. Quick Add (Shto të ri)
- **Zgjidhja:** Butoni **"+ Shto të ri"** në krye të çdo dropdown-i. Sapo shtohet elementi i ri, kodi kthehet te forma prind, rifreskon listën dhe selekton automatikisht elementin e ri.

---

## Modulet që do të ri-shkruhen manualisht (Rendi i punës)

1.  **VehicleBrand & VehicleModel:** Rregullimi i Logos dhe relacionit mes tyre.
2.  **Service & Material:** Rregullimi i Imazheve dhe çmimeve.
3.  **Client:** Pastrimi i fushave të tepërta.
4.  **Job (Më i kompletuari):** Implementimi i plotë me Targat, Shërbimet dhe Statusin fiks si në Livewire.
5.  **Të tjerat (Expenses, Payments, etj.):** Sipas të njëjtit standard.

---

## Verifikimi Final
1.  Bëj update një Material pa prekur foton -> Fotoja duhet të qëndrojë.
2.  Shto një makinë -> Targa duhet të shfaqet në listë dhe te dropdown-i i Punëve.
3.  Hap një Shërbim -> Emri duhet të dalë në shqip (nese është JSON).
