# Tool zur Erstellung von Shopware 6 Plugins und Themes

Dieses Tool wurde entwickelt, um den Prozess der Erstellung von Shopware 6 Plugins und Themes zu automatisieren und zu vereinfachen. Es bietet verschiedene Befehle an, um die folgenden Aktionen durchzuführen:

- ~~**install**:~~ Installiert die erforderlichen Abhängigkeiten und Konfigurationen für die Entwicklung von Shopware 6 Plugins und Themes.
- ~~**update**:~~ Führt Aktualisierungen der Entwicklungsumgebung durch.
- **plugin:create PluginName**: Erstellt ein neues Shopware 6 Plugin mit dem angegebenen Namen und konfiguriert es für die Entwicklung.
- ~~**theme:create ThemeName**:~~ Erstellt ein neues Shopware 6 Theme mit dem angegebenen Namen und konfiguriert es für die Entwicklung.

## Vorraussetzungen

Voraussetzungen
Um dieses Tool zu verwenden, stelle bitte sicher, dass ein Ordner namens "data" vorhanden ist, in dem sich die Datei "auth.json" befindet. Diese Datei wird für die Konfiguration des Plugins oder des Themes benötigt.

Bitte stelle sicher, dass der Ordner "data" im selben Verzeichnis wie das ausführbare Tool vorhanden ist. Wenn der Ordner oder die Datei nicht vorhanden ist, kann das Tool möglicherweise nicht ordnungsgemäß funktionieren.

## Verwendung

Um das Tool zu verwenden, führe die ausführbare Datei aus und gebe einen der oben genannten Befehle ein, gefolgt von den erforderlichen Parametern. Zum Beispiel:

```bash
.\Shopware6DevTool.exe install
```
```bash
.\Shopware6DevTool.exe update
```
```bash
.\Shopware6DevTool.exe plugin:create ExamplePlugin
```
```bash
.\Shopware6DevTool.exe theme:create ExamplePlugin
```
#
Der erste Befehl lädt das Skript script.sh von der angegebenen URL herunter und führt es aus.
Der zweite Befehl macht dasselbe wie der erste, bietet aber zusätzlich die Option, das Flex Recipe durch Angabe von --reset zurückzusetzen.
```bash
curl -s https://raw.githubusercontent.com/KruseMedienGmbH/krme-code-quality-meta/main/script.sh | bash
```

```bash
curl -s https://raw.githubusercontent.com/KruseMedienGmbH/krme-code-quality-meta/main/script.sh | bash -s -- --reset
```