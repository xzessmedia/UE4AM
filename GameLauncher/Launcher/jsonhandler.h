#ifndef JSONHANDLER_H
#define JSONHANDLER_H

#include <QObject>
#include <QNetworkAccessManager>
#include <QNetworkRequest>

class JsonHandler
{
public:
    JsonHandler();
    ~JsonHandler();

    void PostJsonData();
};

#endif // JSONHANDLER_H
