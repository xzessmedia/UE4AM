#ifndef SETTINGS_H
#define SETTINGS_H

#include <QObject>
#include <QSettings>

class Settings
{
public:
    Settings();
    ~Settings();

    QSettings *settings;
    QString   host;
    quint16   buildversion;

};

#endif // SETTINGS_H
