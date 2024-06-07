# Tool zur Erstellung von Shopware 6 Plugins und Themes

Dieses Tool wurde entwickelt, um den Prozess der Erstellung von Shopware 6 Plugins und Themes zu automatisieren und zu vereinfachen. Es bietet verschiedene Befehle an, um die folgenden Aktionen durchzuführen:

- **install**: Installiert die erforderlichen Abhängigkeiten und Konfigurationen für die Entwicklung von Shopware 6 Plugins und Themes.
- **update**: Führt Aktualisierungen der Entwicklungsumgebung durch.
- **plugin:create PluginName**: Erstellt ein neues Shopware 6 Plugin mit dem angegebenen Namen und konfiguriert es für die Entwicklung.
- **theme:create ThemeName**: Erstellt ein neues Shopware 6 Theme mit dem angegebenen Namen und konfiguriert es für die Entwicklung.

## Vorraussetzungen

Voraussetzungen
Um dieses Tool zu verwenden, stelle bitte sicher, dass ein Ordner namens "data" vorhanden ist, in dem sich die Datei "auth.json" befindet. Diese Datei wird für die Konfiguration des Plugins oder des Themes benötigt.

Bitte stelle sicher, dass der Ordner "data" im selben Verzeichnis wie das ausführbare Tool vorhanden ist. Wenn der Ordner oder die Datei nicht vorhanden ist, kann das Tool möglicherweise nicht ordnungsgemäß funktionieren.

## Verwendung

Um das Tool zu verwenden, führen die ausführbare Datei aus und geben einen der oben genannten Befehle ein, gefolgt von den erforderlichen Parametern. Zum Beispiel:

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