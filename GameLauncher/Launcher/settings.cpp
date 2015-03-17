#include "settings.h"

Settings::Settings()
{
    settings = new QSettings("launcher.ini",QSettings::IniFormat);
    settings->beginGroup("app");
    QVariant thost = settings->value("host");
    QVariant tversion = settings->value("version");

    host = thost.toString();
    buildversion = tversion.toInt();
    settings->endGroup();
}

Settings::~Settings()
{

}

