const EndChat = () => {
  return (
    <div className="chat chat-end">
      <div className="chat-image avatar">
        <div className="w-10 rounded-full">
          <img src="pp/bill.jpeg" />
        </div>
      </div>
      <div className="chat-header flex items-center">
        <p className="mr-1 text-center">Utilisateur</p>
      </div>
      <div className="chat-bubble">I hate you!</div>
      <date className="chat-footer opacity-50">Maintenant</date>
    </div>
  );
};
export default EndChat;
