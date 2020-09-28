<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

Prova tecnica successiva al colloquio. <a href="/docs/prova_tecnica.pdf">QUI</a> il documento contenente i requisiti.

Ogni punto del documento di specifica è stato implementato per intero compreso l'extra di cui fornisco dettagli implementativi in seguito.

- [Comandi](#comandi)
- [Configurazione](#configurazione)auto    
    - [Configurazione applicazione (tabella 'configuration')](#configurazione-applicazione-tabella-configuration)
    - [Configurazione GifProvider (tabella 'gif_providers')](#configurazione-gifprovider-tabella-gif_providers)
- [Architettura](#architettura)
    - [Controllers](#controllers)
    - [Injectables](#injectables)
        - [ConfigurationProxy](#configurationproxy)
        - [IGifProvidersProxy](#igifprovidersproxy)
        - [IDefaultGifProviderProxy](#idefaultgifproviderproxy)
        - [IConfigurationProvider](#iconfigurationprovider)
        - [IKeywordProxy](#ikeywordproxy)
    - [Eventi](#eventi)
- [Potenziali miglioramenti](#potenziali-miglioramenti)
- [Esercizio extra: POST /provider/{identifier}/credentials](#esercizio-extra-post-provideridentifiercredentials)

### Comandi
    php artisan cache:flush
Svuota la cache.

    php artisan keyword:resetcount {keyword}
Resetta il contatore della keyword selezionata.

    php artisan config:maxresults {results}
Imposta il numero massimo di risultti da restituire.

    php artisa config:provider {id}
Imposta il GifProvider di default.

### Configurazione
#### Configurazione applicazione (tabella *configuration*)
L'applicazione è configurabile attraverso un insieme di parametri (tabella *configuration*). Ogni insieme di parametri è univocamente identificato tramite un *id*, può essere marcato come *default* e quindi utilizzato dall'applicazione.

>**Parametri configurabili:**
>- ***current_gif_provider*** : gif provider corrente. **ATTENZONE:** questa è una chiave esterna.
>- ***search_term_min_length*** : lunghezza minima di ogni singolo token appartenente alla keyword da ricercare. Valore di default: 3.
>- ***max_results_to_show*** : numero massimo di risultati da restituire per ogni ricerca. Valore di default: 5.
>- ***default_request_protocol*** : protocollo utilizzato nella costruzione delle urls. Valore di default: 'https'.
>- ***sanitation_strategy*** : Strategia di sanificazione dei termini di ricerca. Valore di default: 'basic'.

#### Configurazione GifProvider (tabella 'gif_providers')
Ad ogni provider è associato un insieme di comportamenti specifici e parametri configurabli.

>**Parametri configurabili:**
>- ***description*** : testo descrittivo.
>- ***credentials*** : Json contenente api key e protocollo da utilizzare per comunicare col provider. 
Formato:
>
>       {
>           "api_key" : "myApiKey",
>           "protocol" : "http"
>       }
>- ***research_endpoint*** : endpoint di ricerca del provider.
>- ***research_strategy*** : comportamento di ricerca associato al provider.
>- ***formatter*** : strategia di formattazione dell'output.

### Architettura
#### Controllers
Ad ogni endpoint è associato un metodo di un Controller. 
L'unica  responsabilità dei controller è quella di ricevere la richiesta e fornire una risposta. 
La logica per gestire le varie richieste viene delegata ad un insieme di classi con cui il controller interagisce iniettandole come dipendenze.

#### Injectables
L'applicazione fa ampio uso di classi iniettabili. Per comodità le ho distinte in base al nome pattern che ho pensato di usare per progettarle.

- **Proxy**: Un proxy è una classe che fornisce un interfaccia per interagire con un altro oggetto, solitamente un modello.
- **Provider**: Un provider è una classe che fornisce un interfaccia per richiedere informazioni ad un altro oggetto. Non è possibile manipolare l'oggetto target. Il pattern a cui faccio riferimento è il repository.
- **Strategy**: Incapsula la logica per effettuare una dereminata operazione, come ad esempio una ricerca.

La registrazione di alcune classi è legata alla configurazione dell'applicazione o del GifProvider di default. Alcuni dei valori indicati nelle relative tabelle determineranno la registrazioni di specifiche classi.

Il sistema fornisce di volta in volta gli injectables secondo la configurazione attuale. Qunado questa dovesse cambiare il sistema si aggiornera di conseguenza a run time.

##### ConfigurationProxy
Responsabile per la manipolazione della configurazione come, ad esempio, cambiare il numero massimo di risultati di ricerca.

##### IGifProvidersProxy
Responsabile per la manipolazione ed interrogazione di infaromazioni relative all'insieme dei provider.
NOTA: Questa classe andrebbe rifattorizzata in quanto tutti i getter methods potrebbero essere incapsulati dietro un interfaccia come ad esempio IGifProviders.

##### IDefaultGifProviderProxy
Responsabile delle interazioni col GifProvider correntemente attivo.
**NOTA:** Anche in questa classe vedo una violazione del principio di responsabilità singola. Avrei preferito avere proxy e provider distinti.

##### IConfigurationProvider
Responsabile di fornire informazioni riguardanti la configurazione dell'applicazione.

##### IKeywordProxy
Responsabile per la manipolazione delle keywords.

#### Eventi
L'unico evento utilizzato all'interno dell'applicazione è ***DefaultProviderChanged***. Questo evento viene lanciato quando il GifProvider di default viene cambiato attivando così le operazioni necessarie al cambbio di provider.

### Potenziali miglioramenti
- Si potrebbero utilizzare le code per ottimizzare alcuni compiti come effettuare richieste http. L'assenza di contesto asincrono in php richiederebbe questo tipo di accorgimenti.
- Utilizzare i tags per gestire la cache. I tags non possono essere utilizzati nella versione attaule in quanto utilizza "file" come providere di default. I
nizialmente avevo impostato un server redis quindi vi è traccia dell'utilizzo dei tags. Tuttavia, per velocità di sviluppo ho preferito non lavorare piu con redis.
- Tutte le stringhe contenenti messaggi informativi o errori potrebbero essere gestite tramite value objects o tabelle sul database.

### Esercizio extra: POST /provider/{identifier}/credentials
**Endpoint:** POST /provider/{identifier}/credentials

**Parametri:**
- *identifier* : identificatore del provider di cui si vogliono aggiornare le credenziali

**Payload:**
Json nel formato
>       {
>           "api_key" : "myApiKey",
>           "protocol" : "http"
>       }

**Implementazione:**
Utilizza il metodo ***updateCredentials*** di ***ChangeCredentialsController***.

- Restituisce una risposta senza body, codice 204, in caso di successo.
- Restituisce errore 404 se il provider non esiste o non viene trovato tramite l'identificatore fornito
- Resistuisce errore 418 in caso di payload non valido.