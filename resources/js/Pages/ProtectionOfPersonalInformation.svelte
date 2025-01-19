<script lang="ts">
    // Add any TypeScript logic if necessary
import Navbar from "../Components/Navbar.svelte";
    import Footer from "../Components/Footer.svelte";
</script>

<style lang="scss">
    @use '../../scss/colors.scss' as *;

    .app-container{
        background-color: $primary-mint;
    }

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

    h2, h3 {
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

    ul {
        list-style: none;
        padding-left: 20px;
    }

    ul li {
        margin-bottom: 10px;
        color: #555;
    }

    @media (max-width: 768px) {
        .terms {
            padding: 15px;
            margin: 15px;
        }

        h1 {
            font-size: 1.6rem;
        }

        h2, h3 {
            font-size: 1.3rem;
        }
    }
</style>

<Navbar isSticky={false}></Navbar>
<main class="app-container">
    <div class="terms">
        <h1>Ochrana osobných údajov</h1>

        <h3>I. Základné ustanovenia</h3>
        <p>1. Správcom osobných údajov podľa čl. 4 bod 7 nariadenia Európskeho parlamentu a Rady (EÚ) 2016/679 o ochrane fyzických osôb pri spracovaní osobných údajov a o voľnom pohybe týchto údajov (ďalej len: "GDPR") je Aima, š.f. ,so sídlom Poštová 9, Košice, 04252, Slovenská Republika. (ďalej len: "správca").</p>
        <p>2. Kontaktné údaje správcu sú:</p>
        <ul>
            <li>adresa: Poštová 9 Košice, 04252</li>
            <li>email: aima@aimasf.sk</li>
        </ul>
        <p>3. Osobnými údajmi sú všetky informácie o identifikovanej alebo identifikovateľnej fyzickej osobe; identifikovateľnou fyzickou osobou je fyzická osoba, ktorú možno priamo alebo nepriamo identifikovať, najmä odkazom na určitý identifikátor, napríklad meno, identifikačné číslo, lokačné údaje, sieťový identifikátor alebo pomocou jedného alebo viacerých špecifických faktorov, fyziologických, genetických, mentálnych, ekonomických, kultúrnych alebo spoločenských.</p>
        <p>4. Správca nemenoval poverenca pre ochranu osobných údajov.</p>

        <h3>II. Zdroje a kategórie spracovávaných osobných údajov</h3>
        <p>1. Správca spracováva osobné údaje, ktoré ste mu poskytli alebo osobné údaje, ktoré správca získal na základe plnenia Vašej objednávky.</p>
        <p>2. Správca spracováva Vaše identifikačné a kontaktné údaje a údaje nevyhnutné pre plnenie zmluvy.</p>

        <h3>III. Zákonný dôvod a účel spracovania osobných údajov</h3>
        <p>1. Zákonným dôvodom spracovania osobných údajov je:</p>
        <ul>
            <li>plnenie zmluvy medzi Vami a správcom podľa čl. 6 odst. 1 písm. b) GDPR,</li>
            <li>oprávnený záujem správcu na poskytovaní priameho marketingu (pre zasielanie obchodných oznámení a newsletterov) podľa čl. 6 odst. 1 písm. f) GDPR,</li>
            <li>Váš súhlas so spracovaním pre účely poskytovania priameho marketingu (pre zasielanie obchodných oznámení a newsletterov) podľa čl. 6 odst. 1 písm. a) GDPR v spojení s § 7 odst. 2 zákona č. 480/2004 Zb., o niektorých službách informačnej spoločnosti v prípade, že nedošlo k objednávke tovaru alebo služby.</li>
        </ul>
        <p>2. Účelom spracovania osobných údajov je:</p>
        <ul>
            <li>vybavenie Vašej objednávky a výkon práv a povinností vyplývajúcich zo zmluvného vzťahu medzi Vami a správcom; pri objednávke sú vyžadované osobné údaje, ktoré sú nutné pre úspešné vybavenie objednávky (meno a adresa, kontakt). Poskytnutie osobných údajov je nutným požiadavkom pre uzatvorenie a plnenie zmluvy, bez poskytnutia osobných údajov nie je možné zmluvu uzavrieť alebo ju plniť zo strany správcu.</li>
        </ul>
        <p>3. Zo strany správcu prichádza k automatickému individuálnemu rozhodovaniu v zmysle čl. 22 GDPR. S takým spracovaním ste poskytli svoj výslovný súhlas.</p>

        <h3>IV. Doba uchovávania údajov</h3>
        <p>1. Správca uchováva osobné údaje:</p>
        <ul>
            <li>po dobu nevyhnutnú k výkonu práv a povinností vyplývajúcich zo zmluvného vzťahu medzi Vami a správcom a uplatňovania nárokov z týchto zmluvných vzťahov (po dobu 10 rokov od ukončenia zmluvného vzťahu).</li>
            <li>po dobu, kým je odvolaný súhlas so spracovaním osobných údajov pre účely marketingu, najdlhšie 10 rokov, ak sú osobné údaje spracovávané na základe súhlasu.</li>
        </ul>
        <p>2. Po uplynutí doby uchovávania osobných údajov správca osobné údaje vymaže.</p>

        <h3>V. Príjemcovia osobných údajov (subdodávatelia správcu)</h3>
        <p>1. Príjemcovia osobných údajov sú osoby:</p>
        <ul>
            <li>podieľajúce sa na dodaní tovaru/služieb/realizácii platieb na základe zmluvy.</li>
            <li>zaisťujúce služby prevádzkovania e-shopu a ďalšie služby v súvislosti s prevádzkovaním e-shopu.</li>
            <li>zaisťujúce marketingové služby.</li>
        </ul>
        <p>2. Správca nemá v úmysle poskytnúť osobné údaje do tretej zeme (mimo EU) alebo medzinárodnej organizácii. Príjemcovia osobných údajov v tretích zemiach sú poskytovatelia cloudových služieb.</p>

        <h3>VI. Vaše práva</h3>
        <p>1. Za podmienok stanovených v GDPR máte:</p>
        <ul>
            <li>právo na prístup ku svojim osobným údajom podľa čl. 15 GDPR,</li>
            <li>právo na opravu osobných údajov podľa čl. 16 GDPR, poprípade obmedzenie spracovania podľa čl. 18 GDPR,</li>
            <li>právo na výmaz osobných údajov podľa čl. 17 GDPR,</li>
            <li>právo podať námietku proti spracovávaniu podľa čl. 21 GDPR,</li>
            <li>právo na prenesiteľnosť údajov podľa čl. 20 GDPR,</li>
            <li>právo odvolať súhlas so spracovaním písomne alebo elektronicky na adresu alebo email správcu uvedený v čl. III týchto podmienok.</li>
        </ul>
        <p>2. Ďalej máte právo podať sťažnosť na Úrade pre ochranu osobných údajov v prípade, že sa domnievate, že bolo porušené Vaše právo na ochranu osobných údajov.</p>

        <h3>VII. Podmienky zabezpečenia osobných údajov</h3>
        <p>1. Správca prehlasuje, že prijal všetky technické a organizačné opatrenia k zabezpečeniu osobných údajov.</p>
        <p>2. Správca prijal technické opatrenia k zabezpečeniu dátových úložísk a úložísk osobných údajov v písomnej podobe.</p>
        <p>3. Správca prehlasuje, že k osobným údajom majú prístup len im poverené osoby.</p>

        <h3>VIII. Záverečné ustanovenia</h3>
        <p>1. Odoslaním objednávky z internetového objednávkového formulára potvrzujete, že ste zoznámený s podmienkami ochrany osobných údajov a že ich v celom rozsahu prijímate.</p>
        <p>2. S týmito podmienkami súhlasíte zaškrtnutím súhlasu prostredníctvom internetového formulára. Zaškrtnutím súhlasu potvrdzujete, že ste zoznámený s podmienkami ochrany osobných údajov a že ich v celom rozsahu akceptujete.</p>
        <p>3. Správca je oprávnený tieto podmienky zmeniť. Novú verziu podmienok ochrany osobných údajov zverejní na svojich internetových stránkach a zároveň Vám zašle novú verziu týchto podmienok na Vašu e-mailovú adresu, ktorú ste správcovi poskytli.</p>
    </div>
</main>
<Footer></Footer>
