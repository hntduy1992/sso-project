const Ziggy = {"url":"http:\/\/localhost:8000","port":8000,"defaults":{},"routes":{"dashboard.index":{"uri":"\/","methods":["GET","HEAD"]},"users.index":{"uri":"users","methods":["GET","HEAD"]},"departments.index":{"uri":"departments","methods":["GET","HEAD"]},"permissions.index":{"uri":"permissions","methods":["GET","HEAD"]},"storage.local":{"uri":"storage\/{path}","methods":["GET","HEAD"],"wheres":{"path":".*"},"parameters":["path"]},"storage.local.upload":{"uri":"storage\/{path}","methods":["PUT"],"wheres":{"path":".*"},"parameters":["path"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
