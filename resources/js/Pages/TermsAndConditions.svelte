<script lang="ts">
import Navbar from "../Components/Navbar.svelte";
import Footer from "../Components/Footer.svelte";
</script>

<style>
    .terms {
        background-color: white;
        margin: 30px auto;
        max-width: 900px;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #2c3e50;
        font-size: 2rem;
        margin-bottom: 20px;
    }

    h2 {
        color: #34495e;
        font-size: 1.5rem;
        margin-top: 30px;
        margin-bottom: 10px;
        border-bottom: 2px solid #ecf0f1;
        padding-bottom: 5px;
    }

    p {
        font-size: 1rem;
        line-height: 1.7;
        color: #555;
        margin-bottom: 15px;
    }

    p strong {
        color: #2c3e50;
    }


    @media (max-width: 768px) {
        .terms {
            padding: 15px;
            margin: 15px;
        }

        h1 {
            font-size: 1.6rem;
        }

        h2 {
            font-size: 1.3rem;
        }
    }
</style>

<Navbar></Navbar>
<main class="app-container">
    <div class="terms">
        <h1>Obchodné podmienky</h1>

        <h2>I. Všeobecné ustanovenia a vymedzenie pojmov</h2>

        <p>1. Všeobecné obchodné podmienky (ďalej len podmienky) sa vzťahujú iba na obchodné vzťahy medzi kupujúcim a predávajúcim:</p>
        <p><strong>sídlo:</strong><br>
            Aima, š. f.<br>
            Poštová 9<br>
            04242 Košice<br>
            Slovenská republika<br>
            (ďalej len prevádzkovateľ),</p>
        <p>uzatvorené prostredníctvom internetového obchodu www.aimasf.sk (ďalej len obchod)</p>

        <p>2. Kupujúcim sa rozumie fyzická, alebo právnická osoba, ktorá odoslala objednávku prostredníctvom portálu www.aimasf.sk.</p>

        <p>3. Objednávkou sa rozumie odoslaný elektronický formulár obsahujúci informácie o kupujúcom, zozname objednaného tovaru z ponuky obchodu a celková cena objednávky, spracovaný systémom obchodu.</p>

        <p>4. Všeobecné obchodné podmienky bližšie upravujú a upresňujú práva a povinnosti prevádzkovateľa a kupujúceho vo svojom aktuálnom znení.</p>

        <h2>II. Objednávka, uzatvorenie zmluvy a odstúpenie od zmluvy</h2>

        <p>1. Podmienkou platnosti elektronickej objednávky je pravdivé a úplné vyplnenie všetkých údajov a náležitostí požadovaných systémom pri registrácií, alebo pri realizácii objednávky.</p>

        <p>2. Všetky prijaté elektronické objednávky sú považované za návrh kúpno-predajnej zmluvy a sú považované za záväzné pre obidve zúčastnené strany.</p>

        <p>3. Kupujúci môže zrušiť objednávku bezprostredne po jej odoslaní, pred jej kompletizáciou.</p>

        <p>4. Prevádzkovateľ akceptuje návrh na zmluvu zo strany kupujúceho dodaním tovaru na adresu dodania kupujúcemu.</p>

        <p>5. Faktúra (daňový doklad) bude odoslaná na email zadaný v objednávkovom formulári. Všetky údaje potrebné k realizácii platby budú oznámené emailom až po skompletizovaní objednávky. Neuhradenie faktúry je považované za porušenie obchodných podmienok.</p>

        <p>6. Prevádzkovateľ si vyhradzuje právo dodať len reálne dostupné množstvá kupujúcim objednaných položiek. O takejto situácii bude kupujúci informovaný.</p>

        <h2>III. Dodacie podmienky a termíny</h2>

        <p>1. Miestom plnenia zmluvy sa rozumie bydlisko (sídlo), alebo miesto podnikania kupujúceho uvedené v registračnom formulári obchodu, alebo vo formulári objednávky. Tovar bude dodaný prevádzkovateľom s využitím služieb tretích subjektov (Slovenská pošta, Slovak Parcel Service), alebo dodá tovar vlastnými prostriedkami, resp. na základe dohody s kupujúcim.</p>

        <p>2. Dodanie tovaru je uskutočnené jeho odovzdaním kupujúcemu, prípadne pošte, alebo prvému dopravcovi na prepravu ku kupujúcemu.</p>

        <p>3. Vlastnícke právo na tovar prechádza na kupujúceho pod podmienkou zaplatenia kúpnej sumy v plnej výške.</p>

        <p>4. Prevádzkovateľ objednávku vybaví a odošle objednaný tovar kupujúcemu v čo možno najkratšej dobe (štandardne do 5 pracovných dní) po prijatí elektronickej objednávky. Nedodanie tovaru do 31 kalendárnych dní oprávňuje kupujúceho odstúpiť od zmluvy.</p>

        <p>5. Kupujúci sa zaväzuje prevziať záväzne objednaný tovar. V prípade, že si kupujúci tovar neprevezme, predávajúci si vyhradzuje právo uplatniť svoj nárok na náhradu vzniknutej škody. V prípade, že si zákazník tovar neprevezme pri prvom pokuse o doručenie a požaduje opätovné doručenie tovaru, je povinný uhradiť náklady prvého, opätovného doručenia tovaru, ako aj náklady na vrátenie tovaru predávajúcemu.</p>

        <p>6. Predajca si vyhradzuje právo zmeny spôsobu doručenia zásielky, ak povaha objednaných produktov nezodpovedá požiadavkám prepravcu.</p>

        <h2>IV. Kúpna cena a možnosti platby</h2>

        <p>1. Všetky ceny uvedené na www.aimasf.sk sú vrátane DPH a sú platné pre moment v čase odoslania objednávky.</p>

        <p>2. Prevádzkovateľ si vyhradzuje právo požadovať od kupujúceho platbu vopred bez udania dôvodu, obvykle v prípadoch kedy náklady na doručenie prevyšujú sumu objednaných položiek.</p>

        <p>4. V prípade odmietnutia zaplatiť objednávku vopred, prevádzkovateľ považuje objednávku za neplatnú.</p>

        <p>5. Možnosti platby platobnou kartou cez internetový obchod www.aimasf.sk.</p>

        <p>6. Na platby kartou online používame platobný systém STRIPE.</p>

        <h2>V. Záruka, reklamácie, doklady</h2>

        <p>1. Prevádzkovateľ dodá kupujúcemu všetky náležité doklady, ktoré sa k tovaru vzťahujú spolu s tovarom, to znamená: Faktúru - daňový doklad. Faktúru dostane kupujúci emailom. Tlačenú papierovú formu faktúry Vám zašleme len na vyžiadanie. Uveďte to prosím v poznámke k objednávke.</p>

        <p>2. Prevádzkovateľ poskytuje na dodaný tovar záruku 24 mesiacov odo dňa predaja.</p>

        <p>3. Prevádzkovateľ zodpovedá za závady, ktoré sa na predanom tovare prejavia v záručnej dobe spôsobené závadou materiálu, funkčnou chybou, alebo závady spôsobené pri výrobe.</p>

        <p>4. Záruka sa nevzťahuje na závady spôsobené neodborným zaobchádzaním neprimeraným zaobchádzaním, použitím čí inštaláciou, elektrostatickým výbojom, alebo na závady spôsobené nadmerným mechanickým opotrebením. Záruka sa taktiež nevzťahuje na škody vzniknuté v dôsledku živelnej udalosti, živelnej katastrofy, násilného poškodenia, poveternostných podmienok, alebo prevádzkou v extrémnych a neobvyklých podmienkach.</p>

        <p>5. Kupujúci je povinný informovať predávajúceho na kontaktnej emailovej adrese o prípadnom poškodení objednaného tovaru treťou stranou (prepravcom) bezodkladne a je povinný (v prípade nárokovania si náhradu škody) spísať s kuriérom záznam o škode, ktorý doloží predajcovi pri reklamácii. Bez spísaného záznamu o škode podpísaným kuriérom reklamácia nebude uznaná za opodstatnenú.</p>

        <p>6. Záruka zaniká v prípade neoprávneného zásahu do tovaru osobou, ktorá k vykonaniu zásahu nebola výslovne prevádzkovateľom, alebo výrobcom tovaru zmocnená.</p>

        <h2>VI. Poštovné a balné</h2>

        <p>1. Prevádzkovateľ si vyhradzuje právo zmeniť formu prepravy pri objednávke tovaru, ktorý aj napriek svojej hmotnosti nespĺňa podmienky zvolenej formy prepravy, alebo váhovo po zabalení spadá do vyššej cenovej kategórie prepravcu.</p>

        <p>2. Poštovné sa riadi zmluvnými cenami Slovenskej pošty a zmluvnými cenami spoločnosti Slovak Parcel Service.</p>

        <p>3. Cena za poštovné a balné bude zobrazená v košíku pri objednávaní kupujúcim na základe hmotnosti realizovanej objednávky.</p>

        <h2>VII. Zákon č. 18/2018 Z.Z. O ochrane osobných údajov v znení neskorších predpisov</h2>

        <p>1. Osobné údaje sú spracúvané v súlade so zákonom č. 18/2018 Z. z. o ochrane osobných údajov v znení neskorších predpisov. Prevádzkovateľ neposkytuje osobné údaje kupujúceho tretej osobe, okrem zvolenej prepravnej spoločnosti, ktorá zabezpečuje doručenie tovaru alebo služieb, alebo štátnym orgánom v prípade kontroly, prípadne sprostredkovateľovi a to na základe vzájomnej zmluvy uzatvorenej podľa Zákona č. 18/2018 Z.z.. Prevádzkovateľ je povinný zabezpečiť osobné údaje pred ich sprístupnením neoprávneným osobám, prijatím vhodných technických a organizačných opatrení. Taktiež všetci zamestnanci prevádzkovateľa sú povinní dodržiavať mlčanlivosť vo vzťahu k osobným údajom. Dotknutá osoba má práva vymedzené v zmysle ust. § 19 a nasl. Zákona č. 18/2018 Z.z. o ochrane osobných údajov v znení platných noviel a to konkrétne: a) právo na informácie, ktoré je plnená týmto obsahom a obchodnými podmienkami, b) právo požadovať prístup k osobným údajom týkajúcich sa dotknutej osoby - § 21 Zákona spočíva vo Vašom práve dožadovať sa akým spôsobom a na aké účely sú Vaše údaje spracúvané, c) právo na opravu alebo vymazanie osobných údajov d) právo na obmedzenie spracovania a e) právo na prenosnosť údajov. V prípade, že máte akékoľvek ďalšie otázky alebo požiadavky týkajúce sa spracovania osobných údajov, kontaktujte nás na adrese prevádzkovateľa.</p>
    </div>
</main>
<Footer></Footer>
